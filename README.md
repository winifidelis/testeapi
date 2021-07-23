## API-LARAVEL


## Para executar o projeto
Faça o downlaod do projeto e extraia os arquivos em sua máquina.
Tenha o composer instalado em sua máquina e um banco de dados, este teste foi deito com maria DB.
em um terminal acesse a pasta do projeto e execute o comando
```bash
> composer i
```
abra o projeto e modifique o arquivo .env nas configurações do banco de dados.
execute o comando
```bash
> php artisan migrate:refresh --seed
```
execute o comando abaixo para rodar o projeto

```bash
> php artisan serve
```

a API estará sendo executada