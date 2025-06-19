<?php

use App\Models\Group;
use App\Models\Orders;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Group::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Orders::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('fio')->unique();
            $table->integer('phone')->unique();
            $table->string('addres');
            $table->integer('studentNumber')->unique();
            $table->boolean('is_active')->default(true);
            $table->date('dateStart')->nullable();
            $table->date('dateEnd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
