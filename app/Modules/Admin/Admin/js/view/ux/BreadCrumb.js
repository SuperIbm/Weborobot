Ext.define('Admin.view.ux.BreadCrumb',
	{
    extend: 'Ext.toolbar.Breadcrumb',
	alias: 'widget.AppBreadCrumbExt',
	
	showIcons: true,
	showMenuIcons: true,
	selectAfterInit: true,
	_isSelectAfterInit: false,
	
		findNode: function(property, value)
		{
			function findNext(property, value, nodes)
			{											
				for(var i = 0; i < nodes.length; i++)
				{																		
					if(nodes[i]["data"][property] == value)
					{
					return nodes[i];
					}
					else if(nodes[i]["childNodes"])
					{
					var Node = findNext(property, value, nodes[i]["childNodes"]);
						
						if(Node) return Node;
					}
				}
				
			return null;
			}
		
		return findNext(property, value, [this.getStore().getRoot()]);
		},
		privates:
		{
			_onButtonClick: function(button, e) 
			{
				if(this.getUseSplitButtons()) 
				{
				this.updateSelection(this.getStore().getNodeById(button._breadcrumbNodeId));
				}
			}
		},
		listeners:
		{
			selectionchange: function()
			{
				if(this.selectAfterInit == true) return true;
				else if(this.selectAfterInit == false && this._isSelectAfterInit == true) return true;
				else if(this.selectAfterInit == false && this._isSelectAfterInit == false)
				{
				this._isSelectAfterInit = true;
				return false;	
				}
				
			return false;	
			}
		},
		updateSelection: function(node, com, silent) {
		
			var me = this,
				buttons = me._buttons,
				items = [],
				itemCount = me.items.getCount(),
				needsSync = me._needsSync,
				displayField = me.getDisplayField(),
				showIcons, glyph, iconCls, icon, newItemCount, currentNode, text, button, id, depth, i;
	
			Ext.suspendLayouts();
			
		var silent = silent == undefined ? false : silent;
	
			if (node) {
				currentNode = node;
				depth = node.get('depth');
				newItemCount = depth + 1;
				i = depth;
	
				while (currentNode) {
					id = currentNode.getId();
	
					button = buttons[i];
	
					if (!needsSync && button && button._breadcrumbNodeId === id) {
						// reached a level in the hierarchy where we are already in sync.
						break;
					}
	
					text = currentNode.get(displayField);
	
					if (button) {
						// If we already have a button for this depth in the button cache reuse it
						button.setText(text);
					} else {
						// no button in the cache - make one and add it to the cache
						button = buttons[i] = Ext.create({
							xtype: me.getUseSplitButtons() ? 'splitbutton' : 'button',
							ui: me.getButtonUI(),
							cls: me._btnCls + ' ' + me._btnCls + '-' + me.ui,
							text: text,
							showEmptyMenu: true,
							// begin with an empty menu - items are populated on beforeshow
							menu: {
								listeners: {
									click: '_onMenuClick',
									beforeshow: '_onMenuBeforeShow',
									scope: this
								}
							},
							handler: '_onButtonClick',
							scope: me
						});
					}
	
					showIcons = this.getShowIcons();
	
					if (showIcons !== false) {
						glyph = currentNode.get('glyph');
						icon = currentNode.get('icon');
						iconCls = currentNode.get('iconCls');
	
						if (glyph) {
							button.setGlyph(glyph);
							button.setIcon(null);
							button.setIconCls(iconCls); // may need css to get glyph
						} else if (icon) {
							button.setGlyph(null);
							button.setIconCls(null);
							button.setIcon(icon);
						} else if (iconCls) {
							button.setGlyph(null);
							button.setIcon(null);
							button.setIconCls(iconCls);
						} else if (showIcons) {
							// only show default icons if showIcons === true
							button.setGlyph(null);
							button.setIcon(null);
							button.setIconCls(
								(currentNode.isLeaf() ? me._leafIconCls : me._folderIconCls) + '-' + me.ui
							);
						} else {
							// if showIcons is null do not show default icons
							button.setGlyph(null);
							button.setIcon(null);
							button.setIconCls(null);
						}
					}
	
					button.setArrowVisible(currentNode.hasChildNodes());
					button._breadcrumbNodeId = currentNode.getId();
	
					currentNode = currentNode.parentNode;
					i--;
				}
	
				if (newItemCount > itemCount) {
					// new selection has more buttons than existing selection, add the new buttons
					items = buttons.slice(itemCount, depth + 1);
					me.add(items);
				} else {
					// new selection has fewer buttons, remove the extra ones from the items, but
					// do not destroy them, as they are returned to the cache and recycled.
					for (i = itemCount - 1; i >= newItemCount; i--) {
						me.remove(me.items.items[i], false);
					}
				}
	
			} else {
				// null selection
				me.removeAll(false);
			}
	
			Ext.resumeLayouts(true);
	
			/**
			 * @event selectionchange
			 * Fires when the selected node changes
			 * @param {Ext.toolbar.Breadcrumb} this
			 * @param {Ext.data.TreeModel} node The selected node (or null if there is no selection)
			 */
			
			if(silent == false) me.fireEvent('selectionchange', me, node);
	
			me._needsSync = false;
		}
	}
);