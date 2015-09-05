<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddVectorFontFieldsToFontsTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('fonts', function(Blueprint $table) {     
            
            $table->string('vector_font_file_name')->nullable();
            $table->integer('vector_font_file_size')->nullable();
            $table->string('vector_font_content_type')->nullable();
            $table->timestamp('vector_font_updated_at')->nullable();

        });

    }

    /**
     * Revert the changes to the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fonts', function(Blueprint $table) {

            $table->dropColumn('vector_font_file_name');
            $table->dropColumn('vector_font_file_size');
            $table->dropColumn('vector_font_content_type');
            $table->dropColumn('vector_font_updated_at');

        });
    }

}
