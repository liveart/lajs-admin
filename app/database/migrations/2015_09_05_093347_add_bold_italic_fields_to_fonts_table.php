<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddBoldItalicFieldsToFontsTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('fonts', function(Blueprint $table) {     
            
            $table->string('bold_italic_file_name')->nullable();
            $table->integer('bold_italic_file_size')->nullable();
            $table->string('bold_italic_content_type')->nullable();
            $table->timestamp('bold_italic_updated_at')->nullable();

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

            $table->dropColumn('bold_italic_file_name');
            $table->dropColumn('bold_italic_file_size');
            $table->dropColumn('bold_italic_content_type');
            $table->dropColumn('bold_italic_updated_at');

        });
    }

}
