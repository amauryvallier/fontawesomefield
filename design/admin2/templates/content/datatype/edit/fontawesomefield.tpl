{* DO NOT EDIT THIS FILE! Use an override template instead. *}
{default attribute_base=ContentObjectAttribute}
{def $characters=ezini( 'FontAwesomeSettings', 'CharList', 'fontAwesomeChars.ini' )}
{def $character = $attribute.content.value}
    <select id="ezcoa-{if ne( $attribute_base, 'ContentObjectAttribute' )}{$attribute_base}-{/if}{$attribute.contentclassattribute_id}_{$attribute.contentclass_attribute_identifier}" class="ezcc-{$attribute.object.content_class.identifier} ezcca-{$attribute.object.content_class.identifier}_{$attribute.contentclass_attribute_identifier} faw" name="{$attribute_base}_fontawesomefield_{$attribute.id}">
        <option  value="">{'Not specified'|i18n( 'design/standard/content/datatype' )}</option>
        {foreach $characters as $current_character}
            <option {if $character|eq( $current_character )}selected="selected"{/if} value="{$current_character}">{concat( '&#', $current_character )}</option>
        {/foreach}
    </select>
{undef $characters $character}
{/default}