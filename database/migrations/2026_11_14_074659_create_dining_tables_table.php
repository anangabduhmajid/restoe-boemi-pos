
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dining_tables', function (Blueprint $table) {
            $table->id();

            $table->string('table_number', 20)->unique();
            $table->string('name', 100)->nullable();

            $table->unsignedTinyInteger('capacity')->default(2);

            $table->string('status', 30)->default('available');

            $table->uuid('qr_token')->unique();

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dining_tables');
    }
};
