<p>{ts}The following contacts cannot be deleted because they have values set for the "External Identifier" field.{/ts}</p>

<ul>
  {foreach from=$contacts item=contact}
    {capture assign=viewURL}
      {crmURL p='civicrm/contact/view' q="reset=1&cid=`$contact.id`"}
    {/capture}
    <li><a href="{$viewURL}">{$contact.display_name}</a></li>
  {/foreach}
</ul>

<p><strong>{ts}No contacts have been deleted.{/ts}</strong></p>

<p>{ts}If you need to delete these contacts, then you'll need to do one of the following steps first.{/ts}</p>

<ul>
  <li>{ts}Manually edit the contacts and remove the values in the "External Identifier" field.{/ts}</li>
  <li>{ts}Or ask your administrator to grant you permission to{/ts} <em>{ts}delete contacts with external ID values{/ts}</em>.</li>
  <li>{ts}Or uninstall the External ID Keeper extension.{/ts}</li>
</ul>
