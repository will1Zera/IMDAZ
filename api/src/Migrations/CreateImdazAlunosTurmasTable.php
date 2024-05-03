<?php

namespace App\Migrations;

use App\Models\Database;

class CreateImdazAlunosTurmasTable extends Database
{
    /**
    * Método estático resposável por rodar a migração da tabela.
    *
    * @return void
    */
    public static function up()
    {
        $pdo = self::getConnection();

        $sql = "
            CREATE TABLE IF NOT EXISTS imdaz_alunos_turmas (
                id INT AUTO_INCREMENT PRIMARY KEY,
                aluno_id INT NOT NULL,
                turma_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (aluno_id) REFERENCES imdaz_alunos(id) ON DELETE CASCADE,
                FOREIGN KEY (turma_id) REFERENCES imdaz_turmas(id) ON DELETE CASCADE
            )
        ";

        $pdo->exec($sql);

        echo "Tabela 'imdaz_alunos_turmas' criada com sucesso\n";
    }

    /**
    * Método estático resposável por reverter a migração da tabela.
    *
    * @return void
    */
    public static function down()
    {
        $pdo = self::getConnection();

        $sql = "DROP TABLE IF EXISTS imdaz_alunos_turmas";

        $pdo->exec($sql);

        echo "Tabela 'imdaz_alunos_turmas' removida com sucesso\n";
    }
}
