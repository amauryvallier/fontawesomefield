# fontawesomefield
A simple field type for eZPublish 4 to add a fontawesome character

This has been developped to give the possibility to add personalized icons to a content from the admin editor.

Let's say you had created a field in BO with id="icon", you can display it with something like:

{if $node.data_map.icon.has_content}{concat( '&#', $node.data_map.icon.content.value )}{/if}
