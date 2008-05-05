Smarty lolz :)

{* tc: comment test *}
<h1>{trans domain=products.latest}hello!{/trans}</h1>
{trans zomg="bar" domain="newsletter.signup"  }Your E-Mail Address{/trans}

{snippet src="1px" w="10" h="10" title="close this box"|trans}

{foo bar=baz|trans}

{trans arg1=$messageCount domain="widget.messaging" arg2="some text with \" escaped quotation marks :D"}{singular}You have one new Message{/singular}
{plural}You have %s new Messages{/plural}{/trans}

{foo bar=baz|trans:sdfghjsd:"en_US"}

{snippet src="1px" w="10" h="10" title=closethisbox|trans}

{*tc:comment with following non whitespace chars*}<input type="text" name="foo" value="{trans domain="products.latest"}hello again!{/trans}" />
{trans}lawl{/trans}
