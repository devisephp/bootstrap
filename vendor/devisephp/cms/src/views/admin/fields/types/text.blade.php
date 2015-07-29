<h3>Text</h3>

<p data-devise="text1, text, Text">
    <?= $page->text1->text('This is some default text') ?>
<p>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<p data-devise="text1, text, Text">
    {{ $page->text1->text(\'This is some default text\') }}
<p>
') ?>
</code></pre>

@include('devise::admin.fields.show',
[
    'name' => '$page->text1',
    'values' => $page->text1,
    'descriptions' => [
        'text' => 'The value of the text field'
    ],
])
