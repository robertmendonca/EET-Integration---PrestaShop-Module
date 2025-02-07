{* 
    EET Integration - Synchronization Panel
    This template provides an interface in the PrestaShop back office 
    to manually synchronize products from the EET API. 
*}

<div class="panel">
    {* Panel title *}
    <h3>{l s='EET Integration - Manual Synchronization' mod='eetintegration'}</h3>
    
    {* Description of the synchronization process *}
    <p>{l s='Click the button below to synchronize products from the EET API.' mod='eetintegration'}</p>
    
    {* Button to trigger the synchronization process *}
    <a href="{$sync_link|escape:'html':'UTF-8'}" class="btn btn-primary">
        {l s='Synchronize Now' mod='eetintegration'}
    </a>

    {* Display synchronization results if available *}
    {if isset($sync_result)}
        <div class="alert alert-info">
            <strong>{l s='Synchronization Result:' mod='eetintegration'}</strong>
            <p>{$sync_result nofilter}</p>
        </div>
    {/if}
</div>
