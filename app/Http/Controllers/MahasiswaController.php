<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
* @OA\Info(
*      version="1.0.0",
*      title="API Documentation",
*      description="API Documentation for Mahasiswa"
* )
*
* @OA\Server(
*      url="http://localhost:8000",
*      description="Local Development Server"
* )
*
* @OA\Tag(
*      name="Mahasiswa",
*      description="API Endpoints untuk manajemen data mahasiswa"
* )
*
* @OA\Schema(
*      schema="SuccessResponse",
*      @OA\Property(property="message", type="string", example="Operasi berhasil"),
*      @OA\Property(property="data", type="object")
* )
*
* @OA\Schema(
*      schema="ErrorResponse",
*      @OA\Property(property="message", type="string", example="Error message"),
*      @OA\Property(
*          property="errors",
*          type="object",
*          @OA\Property(property="field", type="array", @OA\Items(type="string"))
*      )
* )
*/
class MahasiswaController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/mahasiswa",
    *     summary="Dapatkan daftar semua mahasiswa",
    *     description="Mengembalikan daftar semua mahasiswa",
    *     operationId="getMahasiswa",
    *     tags={"Mahasiswa"},
    *     @OA\Response(
    *         response=200,
    *         description="Daftar mahasiswa berhasil diambil",
    *         @OA\JsonContent(
    *             type="array",
    *             @OA\Items(ref="#/components/schemas/Mahasiswa")
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Tidak ada data mahasiswa",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Data mahasiswa tidak ditemukan")
    *         )
    *     )
    * )
    */
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        
        if ($mahasiswa->isEmpty()) {
            return response()->json(['message' => 'Data mahasiswa tidak ditemukan'], 404);
        }
        
        return response()->json($mahasiswa, 200);
    }

    /**
    * @OA\Post(
    *     path="/api/mahasiswa",
    *     summary="Tambah mahasiswa baru",
    *     description="Membuat data mahasiswa baru",
    *     operationId="createMahasiswa",
    *     tags={"Mahasiswa"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"nama","nim","email","jurusan"},
    *             @OA\Property(property="nama", type="string", example="John Doe"),
    *             @OA\Property(property="nim", type="string", example="2024004"),
    *             @OA\Property(property="email", type="string", format="email", example="john.doe@university.com"),
    *             @OA\Property(property="jurusan", type="string", example="Teknik Informatika")
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Mahasiswa berhasil ditambahkan",
    *         @OA\JsonContent(ref="#/components/schemas/Mahasiswa")
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Input tidak valid",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Validasi gagal"),
    *             @OA\Property(
    *                 property="errors",
    *                 type="object",
    *                 @OA\Property(property="nama", type="array", @OA\Items(type="string")),
    *                 @OA\Property(property="nim", type="array", @OA\Items(type="string")),
    *                 @OA\Property(property="email", type="array", @OA\Items(type="string")),
    *                 @OA\Property(property="jurusan", type="array", @OA\Items(type="string"))
    *             )
    *         )
    *     )
    * )
    */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:mahasiswas,nim|max:20',
            'email' => 'required|email|unique:mahasiswas,email|max:255',
            'jurusan' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $mahasiswa = Mahasiswa::create($validator->validated());
        return response()->json($mahasiswa, 201);
    }

    /**
    * @OA\Get(
    *     path="/api/mahasiswa/{id}",
    *     summary="Dapatkan detail mahasiswa",
    *     description="Mengembalikan data mahasiswa berdasarkan ID",
    *     operationId="getMahasiswaById",
    *     tags={"Mahasiswa"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID mahasiswa",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Data mahasiswa ditemukan",
    *         @OA\JsonContent(ref="#/components/schemas/Mahasiswa")
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Mahasiswa tidak ditemukan",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Mahasiswa tidak ditemukan")
    *         )
    *     )
    * )
    */
    public function show($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }
        
        return response()->json($mahasiswa);
    }

    /**
    * @OA\Put(
    *     path="/api/mahasiswa/{id}",
    *     summary="Update data mahasiswa",
    *     description="Mengupdate data mahasiswa berdasarkan ID",
    *     operationId="updateMahasiswa",
    *     tags={"Mahasiswa"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID mahasiswa",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"nama","nim","email","jurusan"},
    *             @OA\Property(property="nama", type="string", example="John Doe"),
    *             @OA\Property(property="nim", type="string", example="2024004"),
    *             @OA\Property(property="email", type="string", format="email", example="john.doe@university.com"),
    *             @OA\Property(property="jurusan", type="string", example="Teknik Informatika")
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Data mahasiswa berhasil diupdate",
    *         @OA\JsonContent(ref="#/components/schemas/Mahasiswa")
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Mahasiswa tidak ditemukan",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Mahasiswa tidak ditemukan")
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Input tidak valid",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Validasi gagal"),
    *             @OA\Property(
    *                 property="errors",
    *                 type="object",
    *                 @OA\Property(property="nama", type="array", @OA\Items(type="string")),
    *                 @OA\Property(property="nim", type="array", @OA\Items(type="string")),
    *                 @OA\Property(property="email", type="array", @OA\Items(type="string")),
    *                 @OA\Property(property="jurusan", type="array", @OA\Items(type="string"))
    *             )
    *         )
    *     )
    * )
    */
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:mahasiswas,nim,' . $id,
            'email' => 'required|email|max:255|unique:mahasiswas,email,' . $id,
            'jurusan' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $mahasiswa->update($validator->validated());
        return response()->json($mahasiswa, 200);
    }

    /**
    * @OA\Delete(
    *     path="/api/mahasiswa/{id}",
    *     summary="Hapus data mahasiswa",
    *     description="Menghapus data mahasiswa berdasarkan ID",
    *     operationId="deleteMahasiswa",
    *     tags={"Mahasiswa"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID mahasiswa",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Data mahasiswa berhasil dihapus",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Mahasiswa berhasil dihapus")
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Mahasiswa tidak ditemukan",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Mahasiswa tidak ditemukan")
    *         )
    *     )
    * )
    */
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        $mahasiswa->delete();
        return response()->json(['message' => 'Mahasiswa berhasil dihapus'], 200);
    }
}
