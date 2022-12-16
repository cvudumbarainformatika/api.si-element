<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveyors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()
                ->constrained()
                ->onDelete('cascade');
            $table->bigInteger('nik')->unique();
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('agama')->nullable();
            $table->string('no_hp1')->unique()->nullable();
            $table->string('no_hp2')->unique()->nullable();
            $table->string('nama_npwp')->nullable();
            $table->string('nama_bank')->nullable();
            $table->bigInteger('no_rekening')->unique()->nullable();
            $table->string('nama_buku_tabungan')->nullable();
            $table->bigInteger('no_asuransi_bpjs')->unique()->nullable();
            $table->bigInteger('nilai_toefl')->nullable();
            $table->bigInteger('bivei_id')->nullable();
            $table->bigInteger('stawai_id')->nullable();
            $table->bigInteger('profesi_id')->nullable();
            $table->string('alamat')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabkot')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kodepos')->nullable();
            $table->string('domil_alamat')->nullable();
            $table->string('domil_provinsi')->nullable();
            $table->string('domil_kabkot')->nullable();
            $table->string('domil_kecamatan')->nullable();
            $table->string('domil_kelurahan')->nullable();
            $table->string('domil_kodepos')->nullable();

            $table->tinyInteger('status')->default(1)->comment('1 : Butuh konfirmasi, 2 : Profil kurang, 3 : Profil lengkap');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registers');
    }
};
