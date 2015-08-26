<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddThumbFileFieldsToGraphicsItemsTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('graphicsItems', function(Blueprint $table) {     
            
            $table->string('thumbFile_file_name')->nullable();
            $table->integer('thumbFile_file_size')->nullable();
            $table->string('thumbFile_content_type')->nullable();
            $table->timestamp('thumbFile_updated_at')->nullable();

        });

    }

    /**
     * Revert the changes to the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('graphicsItems', function(Blueprint $table) {

            $table->dropColumn('thumbFile_file_name');
            $table->dropColumn('thumbFile_file_size');
            $table->dropColumn('thumbFile_content_type');
            $table->dropColumn('thumbFile_updated_at');

        });
    }

}
