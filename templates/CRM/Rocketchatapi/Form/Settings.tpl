{*-------------------------------------------------------+
| SYSTOPIA Rocketchat API Extension                      |
| Copyright (C) 2020 SYSTOPIA                            |
| Author: P. Batroff (batroff@systopia.de)               |
+--------------------------------------------------------+
| This program is released as free software under the    |
| Affero GPL license. You can redistribute it and/or     |
| modify it under the terms of this license which you    |
| can read by viewing the included agpl.txt or online    |
| at www.gnu.org/licenses/agpl.html. Removal of this     |
| copyright header is strictly prohibited without        |
| written permission from the original author(s).        |
+-------------------------------------------------------*}


<br/><h3>{ts domain='de.systopia.rocketchatapi'}Rocketchat Server Configuration{/ts}</h3><br/>


<div class="crm-section rocketchatapi rocketchatapi">
  <div class="crm-section">
    <div class="label">{$form.rocketchat_url.label} <a onclick='CRM.help("{ts domain='de.systopia.rocketchatapi'}Rocketchat Server URL{/ts}", {literal}{"id":"id-rocketchatapi-server-url","file":"CRM\/Rocketchatapi\/Form\/Settings"}{/literal}); return false;' href="#" title="{ts domain='de.systopia.rocketchatapi'}Help{/ts}" class="helpicon">&nbsp;</a></div>
    <div class="content">{$form.rocketchat_url.html}</div>
    <div class="clear"></div>
  </div>
  <div class="crm-section">
    <div class="label">{$form.rocketchat_un.label} <a onclick='CRM.help("{ts domain='de.systopia.rocketchatapi'}Rocketchat Account Username{/ts}", {literal}{"id":"id-rocketchatapi-server-username","file":"CRM\/Rocketchatapi\/Form\/Settings"}{/literal}); return false;' href="#" title="{ts domain='de.systopia.rocketchatapi'}Help{/ts}" class="helpicon">&nbsp;</a></div>
    <div class="content">{$form.rocketchat_un.html}</div>
    <div class="clear"></div>
  </div>
  <div class="crm-section">
    <div class="label">{$form.rocketchat_pw.label} <a onclick='CRM.help("{ts domain='de.systopia.rocketchatapi'}Rocketchat Account password{/ts}", {literal}{"id":"id-rocketchatapi-server-password","file":"CRM\/Rocketchatapi\/Form\/Settings"}{/literal}); return false;' href="#" title="{ts domain='de.systopia.rocketchatapi'}Help{/ts}" class="helpicon">&nbsp;</a></div>
    <div class="content">{$form.rocketchat_pw.html}</div>
    <div class="clear"></div>
  </div>
</div>

<div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
