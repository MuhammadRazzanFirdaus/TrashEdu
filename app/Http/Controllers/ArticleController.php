<?php
// app/Http/Controllers/ArticleController.php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArticlesExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        $trash_count = Article::onlyTrashed()->count();
        $month_articles = Article::whereMonth('created_at', now()->month)->count();
        $last_updated = Article::latest('updated_at')->first()?->updated_at;

        return view('admin.article.index', compact(
            'articles',
            'trash_count',
            'month_articles',
            'last_updated'
        ));
    }

    public function create()
    {
        return view('admin.article.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:100'
        ], [
            'title.required' => 'Judul artikel wajib diisi',
            'title.max' => 'Judul artikel maksimal 255 karakter',
            'content.required' => 'Konten artikel wajib diisi',
            'content.min' => 'Konten artikel minimal 100 karakter'
        ]);

        try {
            Article::create($request->all());

            return redirect()->route('admin.articles.index')
                ->with('success', 'Artikel berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Article $article)
    {
        return view('admin.article.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:100'
        ], [
            'title.required' => 'Judul artikel wajib diisi',
            'title.max' => 'Judul artikel maksimal 255 karakter',
            'content.required' => 'Konten artikel wajib diisi',
            'content.min' => 'Konten artikel minimal 100 karakter'
        ]);

        try {
            $article->update($request->all());

            return redirect()->route('admin.articles.index')
                ->with('success', 'Artikel berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Article $article)
    {
        try {
            $article->delete();

            return redirect()->route('admin.articles.index')
                ->with('success', 'Artikel berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $articles = Article::onlyTrashed()->latest()->paginate(10);
        return view('admin.article.trash', compact('articles'));
    }

    public function restore($id)
    {
        try {
            $article = Article::onlyTrashed()->findOrFail($id);
            $article->restore();

            return redirect()->route('admin.articles.trash')
                ->with('success', 'Artikel berhasil dipulihkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            $article = Article::onlyTrashed()->findOrFail($id);
            $article->forceDelete();

            return redirect()->route('admin.articles.trash')
                ->with('success', 'Artikel berhasil dihapus permanen.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $type = $request->get('type', 'all');
        $filename = 'data_artikel_' . date('Y_m_d_His') . '.xlsx';

        return Excel::download(new ArticlesExport($type), $filename);
    }

    public function exportPDF(Request $request)
    {
        $type = $request->get('type', 'all');

        $articles = Article::when($type !== 'all', function ($query) use ($type) {
            $query->where('type', $type);
        })->latest()->get();

        $pdf = Pdf::loadView('admin.article.pdf', [
            'articles' => $articles,
            'export_date' => now(),
            'total' => $articles->count()
        ])->setPaper('a4', 'portrait');

        $filename = 'data_artikel_' . date('Y_m_d_His') . '.pdf';

        return $pdf->download($filename);
    }
}
