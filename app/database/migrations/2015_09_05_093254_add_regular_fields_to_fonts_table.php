<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddRegularFieldsToFontsTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('fonts', function(Blueprint $table) {     
            
            $table->string('regular_file_name')->nullable();
            $table->integer('regular_file_size')->nullable();
            $table->string('regular_content_type')->nullable();
            $table->timestamp('regular_updated_at')->nullable();

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

            $table->dropColumn('regular_file_name');
            $table->dropColumn('regular_file_size');
            $table->dropColumn('regular_content_type');
            $table->dropColumn('regular_updated_at');

        });
    }

}
