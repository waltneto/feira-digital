<?php

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
        // Usuarios (já existe, mas para garantir)
        if (!Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // Produtores
        Schema::create('produtores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->enum('tipo_documento', ['cpf', 'cnpj']);
            $table->string('documento', 20);
            $table->string('telefone', 20);
            $table->string('endereco');
            $table->string('cidade');
            $table->string('estado', 2);
            $table->string('cep', 10);
            $table->timestamps();
            
            $table->foreign('usuario_id')
                  ->references('id')
                  ->on('usuarios')
                  ->onDelete('cascade');
        });

        // Consumidores
        Schema::create('consumidores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->string('cpf', 14)->unique();
            $table->string('telefone', 20);
            $table->timestamps();
            
            $table->foreign('usuario_id')
                  ->references('id')
                  ->on('usuarios')
                  ->onDelete('cascade');
        });

        // Feiras
        Schema::create('feiras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produtor_id');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim');
            $table->string('endereco');
            $table->string('cidade');
            $table->string('estado', 2);
            $table->string('cep', 10);
            $table->enum('status', ['agendada', 'em_andamento', 'concluida', 'cancelada'])->default('agendada');
            $table->boolean('ativa')->default(true);
            $table->timestamps();
            
            $table->foreign('produtor_id')
                  ->references('id')
                  ->on('produtores')
                  ->onDelete('cascade');
        });

        // Produtos
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produtor_id');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->decimal('preco', 10, 2);
            $table->string('unidade_medida');
            $table->string('foto')->nullable();
            $table->boolean('organico')->default(false);
            $table->boolean('disponivel')->default(true);
            $table->timestamps();
            
            $table->foreign('produtor_id')
                  ->references('id')
                  ->on('produtores')
                  ->onDelete('cascade');
        });

        // Tabela pivô feira_produto
        Schema::create('feira_produto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feira_id');
            $table->unsignedBigInteger('produto_id');
            $table->integer('quantidade_disponivel')->default(0);
            $table->timestamps();
            
            $table->foreign('feira_id')
                  ->references('id')
                  ->on('feiras')
                  ->onDelete('cascade');
            
            $table->foreign('produto_id')
                  ->references('id')
                  ->on('produtos')
                  ->onDelete('cascade');
        });

        // Carrinhos
        Schema::create('carrinhos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consumidor_id');
            $table->unsignedBigInteger('feira_id');
            $table->timestamps();
            
            $table->foreign('consumidor_id')
                  ->references('id')
                  ->on('consumidores')
                  ->onDelete('cascade');
            
            $table->foreign('feira_id')
                  ->references('id')
                  ->on('feiras')
                  ->onDelete('cascade');
        });

        // Itens Carrinho
        Schema::create('itens_carrinho', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('carrinho_id');
            $table->unsignedBigInteger('produto_id');
            $table->integer('quantidade');
            $table->decimal('preco_unitario', 10, 2);
            $table->timestamps();
            
            $table->foreign('carrinho_id')
                  ->references('id')
                  ->on('carrinhos')
                  ->onDelete('cascade');
            
            $table->foreign('produto_id')
                  ->references('id')
                  ->on('produtos')
                  ->onDelete('cascade');
        });

        // Pedidos
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consumidor_id');
            $table->unsignedBigInteger('feira_id');
            $table->string('codigo_pedido')->unique();
            $table->enum('status', ['pendente', 'confirmado', 'preparando', 'pronto', 'entregue', 'cancelado'])->default('pendente');
            $table->decimal('total', 10, 2);
            $table->text('codigo_qr')->nullable();
            $table->timestamps();
            
            $table->foreign('consumidor_id')
                  ->references('id')
                  ->on('consumidores')
                  ->onDelete('cascade');
            
            $table->foreign('feira_id')
                  ->references('id')
                  ->on('feiras')
                  ->onDelete('cascade');
        });

        // Itens Pedido
        Schema::create('itens_pedido', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('produto_id');
            $table->integer('quantidade');
            $table->decimal('preco_unitario', 10, 2);
            $table->timestamps();
            
            $table->foreign('pedido_id')
                  ->references('id')
                  ->on('pedidos')
                  ->onDelete('cascade');
            
            $table->foreign('produto_id')
                  ->references('id')
                  ->on('produtos')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_pedido');
        Schema::dropIfExists('pedidos');
        Schema::dropIfExists('itens_carrinho');
        Schema::dropIfExists('carrinhos');
        Schema::dropIfExists('feira_produto');
        Schema::dropIfExists('produtos');
        Schema::dropIfExists('feiras');
        Schema::dropIfExists('consumidores');
        Schema::dropIfExists('produtores');
    }
};