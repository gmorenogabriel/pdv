<div>Este texto es original</div>
<div>Sub titulos</div>
<hr>
<div style="color: red">{frase}</div>
{# comentario de parser que no se muestra #}
<ul>
    {nomes}
        <li>{nome}</li>
    {/nomes}
</ul>

<p>El utilizador admin?</p>
{if($admin)}
<p>Si</p>
{else}
<p>No</p>
{endif}

{# no parse no convierte y deja el texto en forma literal #}
{noparse}
<p>Este es un Texto {literar}</p>
{/noparse}