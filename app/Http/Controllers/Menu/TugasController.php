<?php

namespace App\Http\Controllers\Menu;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = (int) $request->input('perPage', 10); 
        $search = $request->input('search');

        $assignmentsQuery = Assignment::with('lecturer')->orderBy('start_date', 'desc');

        if ($search) {
            $assignmentsQuery->where('title', 'like', '%' . $search . '%');
        }

        if ($user->role === 'mahasiswa') {
            $studentId = $user->id;
            
            $todoTasks = collect();
            $missedTasks = collect();
            $completedTasks = collect();
            
            foreach ($assignmentsQuery->get() as $assignment) {
                // Cek apakah mahasiswa sudah submit
                $hasSubmitted = $assignment->submissions()->where('student_id', $studentId)->exists();
                
                if ($hasSubmitted) {
                    $assignment->status_dynamic = 'completed';
                    $completedTasks->push($assignment);
                } elseif (now()->between($assignment->start_date, $assignment->deadline)) {
                    $assignment->status_dynamic = 'in progress';
                    $todoTasks->push($assignment);
                } elseif (now()->gt($assignment->deadline)) {
                    $assignment->status_dynamic = 'missed';
                    $missedTasks->push($assignment);
                }
            }
            
            return view('menu.tugas.index', compact('todoTasks', 'completedTasks', 'missedTasks'));
        }
        
        // Jika user adalah dosen
        foreach ($assignmentsQuery->get() as $assignment) {
            if (now()->lt($assignment->start_date)) {
                $assignment->status_dynamic = 'scheduled';
            } elseif (now()->between($assignment->start_date, $assignment->deadline)) {
                $assignment->status_dynamic = 'in progress';
            } else {
                $assignment->status_dynamic = 'completed';
            }
        }
        
        // Gunakan paginate untuk mendapatkan paginasi
        $assignments = $assignmentsQuery->paginate($perPage);
        
        // Kembalikan view dengan data paginasi
        return view('menu.tugas.index', [
            'assignments' => $assignments,
            'search' => $search,
        ]);
    }

   public function create() {
        return view('menu.tugas.create');
   }

   public function store(Request $request)
   {
       $validated = $request->validate([
           'title'       => 'required|string|max:255',
           'description' => 'nullable|string',
           'start_date'  => 'required|date',
           'deadline'    => 'required|date|after_or_equal:start_date',
       ]);
   
       // Menyimpan data tugas
       $validated['lecturer_id'] = Auth::id();
   
       // Cek apakah waktu sekarang sudah melewati start_date
       $now = Carbon::now();
       $startDate = Carbon::parse($validated['start_date']);
   
       $validated['status'] = $now->greaterThanOrEqualTo($startDate) ? 'in progress' : 'scheduled';
   
       // Simpan tugas
       Assignment::create($validated);
   
       return $request->submit === 'buat_lagi'
           ? back()->with('success', 'Tugas berhasil disimpan. Silakan buat tugas lainnya.')
           : redirect()->route('assignments.dosen.index')->with('success', 'Tugas berhasil dibuat.');
   }
   
   

   public function submission(Assignment $assignment)
   {
       $user = Auth::user();
   
       if (!$user) {
           abort(403, 'Unauthorized');
       }
   
       // Ambil submission berdasarkan assignment dan student_id
       $submission = Submission::where('assignment_id', $assignment->id)
                               ->where('student_id', $user->id)
                               ->first();
   
       // Pastikan jika submission ditemukan, kita ambil data files yang terkait
       if ($submission) {
           // Memuat relasi files dengan submission
           $files = $submission->files; 
       } else {
           $files = [];
       }
   
       return view('menu.tugas.submission', compact('assignment', 'submission', 'files'));
   }
   

   public function storeSubmission(Request $request, Assignment $assignment): JsonResponse
   {
       $user = Auth::user();
   
       // Cegah submit ulang
       $existing = Submission::where('assignment_id', $assignment->id)
                              ->where('student_id', $user->id)
                              ->exists();
   
       if ($existing) {
           return response()->json([
               'status' => 'error',
               'message' => 'Tugas sudah dikumpulkan sebelumnya.'
           ], 409); // Conflict
       }
   
       // Validasi file
       $validated = $request->validate([
           'files' => 'required',
           'files.*' => 'file|mimes:pdf,docx,zip,rar|max:10240',
       ]);
   
       DB::beginTransaction();
       try {
           // Simpan submission
           $submission = Submission::create([
               'assignment_id' => $assignment->id,
               'student_id' => $user->id,
               'submitted_at' => now(),
           ]);
   
           $uploadedFiles = $request->file('files');
           if (!is_array($uploadedFiles)) {
               $uploadedFiles = [$uploadedFiles];
           }
   
           foreach ($uploadedFiles as $file) {
                $originalName = str_replace(' ', '_', $file->getClientOriginalName());
                $path = $file->storeAs('submissions', $originalName, 'public');
            
                $submission->files()->create([
                    'file' => $path,
                ]);
            }        
   
           DB::commit();
   
           return response()->json([
               'status' => 'success',
               'message' => 'Tugas berhasil dikumpulkan.',
               'redirect' => route('assignments.mahasiswa.submission', $assignment->id)
           ]);
       } catch (\Exception $e) {
           DB::rollBack();
   
           return response()->json([
               'status' => 'error',
               'message' => 'Gagal menyimpan tugas. ' . $e->getMessage()
           ], 500);
       }
   }
   
   public function edit($id) 
   {
        $assignment = Assignment::findOrFail($id);
        return view('menu.tugas.edit', compact('assignment'));
    }
   
    public function update(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);
    
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'deadline' => 'required|date|after_or_equal:start_date',
        ]);
    
        $assignment->update($validated);
    
        return redirect()->route('assignments.dosen.index')
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    public function show(Assignment $assignment)
    {
        // Pastikan assignment valid
        return view('menu.tugas.show', compact('assignment'));
    }

    public function submissions(Assignment $assignment)
    {
        $submissions = $assignment->submissions()->with('student')->latest()->paginate(10);

        return view('menu.tugas.submitted', compact('assignment', 'submissions'));
    }

    public function beriNilai(Request $request, Submission $submission)
    {
        $request->validate([
            'score' => 'required|numeric|min:0|max:100',
        ]);

        $submission->update([
            'score' => $request->score,
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil disimpan.');
    }

    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();

        return redirect()->route('assignments.dosen.index')->with('success', 'Tugas berhasil dihapus.');
    }



   public function history() {
        return view('menu.tugas.history');
   }
}
