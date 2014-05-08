<p>{{ link_to('books/index', 'Back to list') }}</p>
<hr>
<h1>{{ book.name|e }}</h1>
<p>Author: {{ book.author|e }}</p>
<p>Published: {{ book.datePublished.format('Y-m-d')|e }}</p>