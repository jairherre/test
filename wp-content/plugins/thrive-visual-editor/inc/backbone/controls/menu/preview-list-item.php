<#if(typeof no_item !== 'undefined' && no_item){#>
<div class="list-no-items tcb-text-center"><?php echo __( 'None', 'thrive-cb' ); ?></div>
<#} else {#>
<div class="preview-list-item tcb-relative<#=item.get('second_level') ? ' second-level':'' #><#=item.get('icon') ? '' : ' no-icon'#>"
		data-fn="item_click" data-index="<#=item.index#>" data-id="<#=item.get('item_id')#>" data-label="<#=item.get('label')#>">
	<div class="preview-list-sort-handle col-sep"><?php tcb_icon( 'dots2' ); ?></div>
	<div class="item-label tcb-truncate"><span><#=item.get('label')#></span></div>
	<a href="javascript:void(0)" title="<?php esc_attr_e( 'Edit', 'thrive-cb' ); ?>" class="action-edit click" data-fn-click="tab_click"
			data-index="<#=item.index#>" data-label="<#=item.get('label')#>" data-child-index="<#= item.child_index #>">
		<?php tcb_icon( 'pen-regular' ); ?>
	</a>
	<a href="javascript:void(0)" title="<?php esc_attr_e( 'Remove', 'thrive-cb' ); ?>" class="action-remove click" data-fn="item_remove"
			data-index="<#=item.index#>" data-child-index="<#= item.child_index #>">
		<?php tcb_icon( 'trash-light' ); ?>
	</a>
</div>
<#}#>