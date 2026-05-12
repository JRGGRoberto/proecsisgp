```mermaid
erDiagram
    Campi {
        int id
        string name
    }

    Centros {
        int id
        string name
        int campi_id
    }

    Agentes {
        int id
        string name
        int campi_id
    }

    Professores {
        int id
        string name
        int centro_id
    }

    Usuarios {
        int id
        string name
    }

    Projetos {
        int id
        string title
        int user_id
    }

    Campi ||--o{ Centros : contains
    Campi ||--o{ Agentes : contains
    Centros ||--o{ Professores : contains
    Professores ||--o{ Usuarios : "forms"
    Agentes ||--o{ Usuarios : "forms"
    Usuarios ||--o{ Projetos : creates


```
```

## Configuração
As credenciais do banco de dados estão no arquivo `./app/Db/Database.php` e você deve alterar para as configurações do seu ambiente (HOST, NAME, USER e PASS).

## Composer
Para a aplicação funcionar, é necessário rodar o Composer para que sejam criados os arquivos responsáveis pelo autoload das classes.

Caso não tenha o Composer instalado, baixe pelo site oficial: [https://getcomposer.org/download](https://getcomposer.org/download/)

Para rodar o composer, basta acessar a pasta do projeto e executar o comando abaixo em seu terminal:
```shell
 composer install
```

Após essa execução uma pasta com o nome `vendor` será criada na raiz do projeto e você já poderá acessar pelo seu navegador.
