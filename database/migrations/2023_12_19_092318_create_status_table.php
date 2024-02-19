<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('status_desc')->unique();

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        \Database\Factories\StatusFactory::new()->count(1)->create();
        \Database\Factories\StatusFactory::new()->claim()->create();
        \Database\Factories\StatusFactory::new()->working()->create();
        \Database\Factories\StatusFactory::new()->pending()->create();

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status');
    }
};
