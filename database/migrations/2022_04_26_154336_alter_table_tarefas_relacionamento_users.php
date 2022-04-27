<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterTableTarefasRelacionamentoUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();
        try{
            Schema::table('tarefas', function(Blueprint $table){
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users');
            });
            DB::commit();
        }catch(\Exception $ex){
            DB::rollback();
            throw $ex;
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarefas', function(Blueprint $table){
            $table->dropForeign('tarefas_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
}
