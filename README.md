### O QUE É

Um QueryBuilder e SqlSchema que o banco de dados com a orientação a objetos do PHP.

### A QUEM SE DESTINA / OBJETIVO

Este projeto é mantido sob a licença MIT e stá disponível para uso em projetos cujo a implematação é feita com PHP e JavaScript puros, sem uso de frameWorks na base.

### INSTALAÇÃO LOCAL

• Em seu servidor local baixe o projeto usando `git clone`;
• Cole os arquivos no local desejado;
• Altere os namespaces dos arquivos caso necessário;

### CONVENÇÕES

Convenções adotadas no ambiente de trabalho para o projeto:

- O nome das das classes devem ser iguais aos das tabelas do banco de dados
- Todos os `métodos de get e set` devem conter um `_` depois dos prefixos get e set: **_get_name e set_name_**;
- Todos os `métodos de get e set` devem ter os nomes correspondentes de cada coluna

### BANCO DE DADOS

A implementação padrão desse projeto foi feito para suportar o Banco de Dados Oracle Sql.
Outros bancos devem ser implementados de acordo com a interface `DataBaseConnectionInterface`.

---

#### SOBRE O AUTOR/ORGANIZADOR

Tiago Silva
tsilvasantos38@gmail.com
