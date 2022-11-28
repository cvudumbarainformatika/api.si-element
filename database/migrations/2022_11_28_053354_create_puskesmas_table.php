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
        Schema::create('puskesmas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()
                ->constrained()
                ->onDelete('cascade');
            $table->bigInteger('nomor')->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('alamat')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabkot')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kodepos')->nullable();
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
        Schema::dropIfExists('puskesmas');
    }
};
