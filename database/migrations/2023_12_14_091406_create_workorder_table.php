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
        Schema::create('workorder', function (Blueprint $table) {
            $table->id();
            $table->string('workorder_desc');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onUpdate('cascade');
            $table->string('device');
            $table->string('model');
            $table->string('serial');
            $table->string('access');
            $table->string('issue');
            $table->boolean('inspection')->default(false);
            $table->boolean('software')->default(false);
            $table->boolean('interview')->default(false);
            $table->boolean('replacement')->default(false);
            $table->boolean('patch')->default(false);
            $table->boolean('backup')->default(false);
            $table->boolean('other')->default(false);
            $table->string('other_desc')->nullable();
            $table->time('completion_time');
            $table->date('start_date');
            $table->date('completion_date');
            $table->decimal('labor_charges')->default(0);
            $table->decimal('software_cost')->default(0);
            $table->decimal('miscellaneous_expense')->default(0);
            $table->decimal('total_cost')->default(0);
            $table->integer('status_id')->default(1);

            $table->timestamp('status_at')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workorder');
    }
};
