<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Mahasiswa",
 *     description="Model Mahasiswa",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID mahasiswa"
 *     ),
 *     @OA\Property(
 *         property="nama",
 *         type="string",
 *         description="Nama mahasiswa"
 *     ),
 *     @OA\Property(
 *         property="nim",
 *         type="string",
 *         description="Nomor Induk Mahasiswa"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="Email mahasiswa"
 *     ),
 *     @OA\Property(
 *         property="jurusan",
 *         type="string",
 *         description="Jurusan mahasiswa"
 *     )
 * )
 */
class Mahasiswa extends Model
{
    protected $fillable = ['nama', 'nim', 'email', 'jurusan'];
}
