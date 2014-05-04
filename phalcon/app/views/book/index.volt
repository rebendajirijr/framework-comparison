<p>{{ link_to('books/index', 'Back to list') }}</p>
<hr>
<h1>{{ book.name }}</h1>
<p>Author: {{ book.author }}</p>
<p>Published: {{ book.datePublished.format('Y-m-d') }}</p>