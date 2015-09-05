<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddItalicFieldsToFontsTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('fonts', function(Blueprint $table) {     
            
            $table->string('italic_file_name')->nullable();
            $table->integer('italic_file_size')->nullable();
            $table->string('italic_content_type')->nullable();
            $table->timestamp('italic_updated_at')->nullable();

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

            $table->dropColumn('italic_file_name');
            $table->dropColumn('italic_file_size');
            $table->dropColumn('italic_content_type');
            $table->dropColumn('italic_updated_at');

        });
    }

}
