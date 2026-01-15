<?php

// database/migrations/xxxx_xx_xx_create_encyclopedia_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Tabel Master (Independen)
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('lemmas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('media_types', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // misal: image, video
            $table->timestamps();
        });

        Schema::create('media_positions', function (Blueprint $table) {
            $table->id();
            $table->string('position'); // misal: header, body, footer
            $table->timestamps();
        });

        // 2. Tabel Utama (Content)
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cat_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('title_id')->constrained('lemmas')->onDelete('cascade'); // title_id merujuk ke lemma
            $table->string('year')->nullable();
            $table->longText('text');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 3. Tabel Relasi (Dependent)
        Schema::create('ref_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained('contents')->onDelete('cascade');
            $table->longText('name');
            $table->longText('link');
            $table->timestamps();
        });

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('media_types');
            $table->foreignId('content_id')->constrained('contents')->onDelete('cascade');
            $table->foreignId('position_id')->constrained('media_positions');
            $table->longText('link'); // Path file atau URL
            $table->longText('caption')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('media');
        Schema::dropIfExists('ref_links');
        Schema::dropIfExists('contents');
        Schema::dropIfExists('media_positions');
        Schema::dropIfExists('media_types');
        Schema::dropIfExists('lemmas');
        Schema::dropIfExists('categories');
    }
};
