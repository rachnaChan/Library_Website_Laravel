<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    //upload book, file and image

    public function uploadBook(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'isbn' => 'nullable|string',
            'author' => 'nullable|string',
            'release_year' => 'nullable|integer',
            'description' => 'nullable|string',
            'categories_type' => 'nullable|string',
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'private');
            } else {
                return response()->json(['error' => 'File not found'], 400);
            }

            // Create a new Book instance
            $book = new Books();
            $book->file_name = $fileName;
            $book->file_path = $filePath;
            $book->isbn = $request->input('isbn');
            $book->author = $request->input('author');
            $book->release_year = $request->input('release_year');
            $book->description = $request->input('description');
            $book->categories_type = $request->input('categories_type');
            $book->user_id = auth()->id();

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('uploads', $imageName, 'public');
                $book->image = $imagePath;
            }

            // Save the book details to the database
            $book->save();

            return response()->json([
                'message' => 'Book uploaded successfully',
                'book' => $book,
            ], 200);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //get book belong to which user
    public function getBooks()
    {
        $documents = Books::where('user_id', auth()->id())->get();
        return response()->json($documents);
    }

    //delete book belong to which user
    public function deleteBook($id)
    {
        $book = Books::findOrFail($id);
        $oldfile = $book->file_path;
        $oldimage = $book->image;

        if ($oldfile) {
            Storage::disk('private')->delete($oldfile);
        }
        if ($oldimage) {
            Storage::disk('public')->delete($oldimage);
        }

        // Delete the book record from the database
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }

    //preview file student
    public function previewBook(string $bookId)
    {
        return response()->file(storage_path('app/private/uploads/' .  $bookId));
    }


    public function listBooks()
    {
        try {
            // Fetch all books
            $books = Books::all();

            // Return the list of books
            return response()->json([
                'message' => 'List of all books retrieved successfully',
                'books' => $books,
            ], 200);
        } catch (\Exception $e) {
            // Handle exceptions if an error occurs
            return response()->json(['error' => 'Failed to retrieve books'], 500);
        }
    }

    public function listArrivalBooks()
    {
        try {
            // Fetch the latest five books based on the creation date (assuming 'created_at' field exists)
            $latestBooks = Books::orderBy('created_at', 'desc')->take(5)->get();

            // Return the list of latest books
            return response()->json([
                'message' => 'List of latest five books retrieved successfully',
                'latest_books' => $latestBooks,
            ], 200);
        } catch (\Exception $e) {
            // Handle exceptions if an error occurs
            return response()->json(['error' => 'Failed to retrieve latest books'], 500);
        }
    }

    public function searchBook($query)
    {
        $books = Books::where(function ($q) use ($query) {
            $q->where('file_name', 'like', "%$query%")
                ->orWhere('author', 'like', "%$query%")
                ->orWhere('categories_type', 'like', "%$query%")
                ->orWhere('isbn', '=', $query);
        })->get();

        return response()->json($books);
    }

    public function updateBook(Request $request, $bookId)
    {
        $request->validate([
            'file' => 'nullable|mimes:pdf|max:10000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'author' => 'nullable|string',
            'release_year' => 'nullable|integer',
            'description' => 'nullable|string',
            'categories_type' => 'nullable|string',
        ]);

        try {
            $book = Books::findOrFail($bookId);

            // Handle file replacement and delete old file
            if ($request->hasFile('file')) {
                $oldFilePath = $book->file_path;
                $oldFileName = $book->file_name;

                $file = $request->file('file');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $newFilePath = $file->storeAs('uploads', $newFileName, 'private');

                $book->file_name = $newFileName;
                $book->file_path = $newFilePath;

                // Delete old file from storage
                if (Storage::disk('private')->exists($oldFilePath)) {
                    Storage::disk('private')->delete($oldFilePath);
                }
            }

            // Update other book information
            $book->author = $request->input('author', $book->author);
            $book->release_year = $request->input('release_year', $book->release_year);
            $book->description = $request->input('description', $book->description);
            $book->categories_type = $request->input('categories_type', $book->categories_type);

            // Handle image replacement and delete old image
            if ($request->hasFile('image')) {
                $oldImagePath = $book->image;

                $image = $request->file('image');
                $newImageName = time() . '_' . $image->getClientOriginalName();
                $newImagePath = $image->storeAs('uploads', $newImageName, 'public');

                $book->image = $newImagePath;

                // Delete old image from storage
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            // Save updated book details to the database
            $book->save();

            return response()->json([
                'message' => 'Book updated successfully',
                'book' => $book,
            ], 200);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
