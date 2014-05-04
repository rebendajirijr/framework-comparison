<p>{{ link_to('index', 'Homepage') }}</p>
<hr>
<h1>Books</h1>
<ul>
	{% for book in books %}
	<li>
		{{ link_to('book/index/' ~ book.id, book.name ~ ' (' ~ book.datePublished.format('Y') ~ ')') }}
	</li>
	{% endfor %}
</ul>