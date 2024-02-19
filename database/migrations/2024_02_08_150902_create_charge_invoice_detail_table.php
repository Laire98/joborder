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
        Schema::create('charge_invoice_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('charge_id');
            $table->foreign('charge_id')->references('id')->on('charge_invoice')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->string('unit');
            $table->string('articles');
            $table->decimal('price')->default(0);
            $table->decimal('total')->default(0);

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charge_invoice_detail');
    }
};
