Smarty lolz :)

{* tc: comment test *}
{trans domain=products.latest}hello!{/trans}
{trans zomg="bar" domain="newsletter.signup"  }Your E-Mail Address{/trans}

{foo bar=baz|trans:sdfghjsd:"en_US"}

{trans arg1=$messageCount domain="widget.messaging" arg2="some text with \" escaped quotation marks :D"}{singular}You have one new Message{/singular}
{plural}You have %s new Messages{/plural}{/trans}

{*tc:comment with following non whitespace chars*}<input type="text" name="foo" value="{trans domain="products.latest"}hello again!{/trans}" />
{trans}lawl{/trans}
