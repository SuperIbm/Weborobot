Ext.define('User.view.UserRoleCreateAdminSectionGrid', 
	{
    extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.User.view.UserRoleCreateAdminSectionGrid',
	
		requires:
		[
		'AdminSection.view.AdminSectionGrid'
		],
	
	name: "User",
	viewConfig: null,
	dblclickUpdate: false,
	border: true,
	
		features: 
		[
			{
			id: 'UserRoleCreateAdminSectionGrid',
			ftype: 'grouping',
			groupHeaderTpl: '{name}',
			hideGroupedHeader: true,
			enableGroupingMenu: false
			}
		],
		
		columns:
		[
			{
			header: 'Название раздела',
			dataIndex: 'labelSection',
			width: "37%"
			},
			{
			header: 'Читать',
			dataIndex: 'nameModule',
			width: "12%",			
				renderer: function(val, x, rec)
				{																			
					if(rec.get("status") == "Не активен")
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isRead]' value='1' disabled='disabled' />";
					}
					else if(Admin.getApplication().Access.has("role", "Администрирование") == true)
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isRead]' value='1' />"
					}
					else
					{
						if(Admin.getApplication().Access.is(rec.get("nameModule"), "isRead") == true)
						{
						return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isRead]' value='1' />"
						}
						else
						{
						return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isRead]' value='1' disabled='disabled' />"
						}
					}
				}
			},
			{
			header: 'Публиковать',
			dataIndex: 'nameModule',
			width: "12%",
			hideable: false,
				renderer: function(val, x, rec)
				{	
					if(rec.get("status") == "Не активен")
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isCreate]' value='1' disabled='disabled' />";
					}
					else if(Admin.getApplication().Access.has("role", "Администрирование") == true)
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isCreate]' value='1' />"
					}
					else
					{
						if(Admin.getApplication().Access.is(rec.get("nameModule"), "isCreate") == true)
						{
						return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isCreate]' value='1' />"
						}
						else
						{
						return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isCreate]' value='1' disabled='disabled' />"
						}
					}
				}
			},
			{
			header: 'Редактировать',
			dataIndex: 'nameModule',
			width: "12%",
				renderer: function(val, x, rec)
				{							
					if(rec.get("status") == "Не активен")
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isUpdate]' value='1' disabled='disabled' />";
					}
					else if(Admin.getApplication().Access.has("role", "Администрирование") == true)
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isUpdate]' value='1' />"
					}
					else
					{
						if(Admin.getApplication().Access.is(rec.get("nameModule"), "isUpdate") == true)
						{
						return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isUpdate]' value='1' />"
						}
						else
						{
						return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isUpdate]' value='1' disabled='disabled' />"
						}
					}
				}
			},
			{
			header: 'Удалять',
			dataIndex: 'nameModule',
			width: "12%",
				renderer: function(val, x, rec)
				{					
					if(rec.get("status") == "Не активен")
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isDestroy]' value='1' disabled='disabled' />";
					}
					else if(Admin.getApplication().Access.has("role", "Администрирование") == true)
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isDestroy]' value='1' />"
					}
					else
					{
						if(Admin.getApplication().Access.is(rec.get("nameModule"), "isDestroy") == true)
						{
						return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isDestroy]' value='1' />"
						}
						else
						{
						return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isDestroy]' value='1' disabled='disabled' />"
						}
					}
				}
			},
			{
			header: 'Статус',
			dataIndex: 'status',
			width: "15%"
			}
		],
		listeners: 
		{
			afterlayout: function(container, layout, eOpts)
			{			
				$("#" + this.id + " INPUT").click
				(
					function()
					{
						if($(this).filter("[name$='[isRead]']").length == 1)
						{					
							if($(this).is(":disabled") == false)
							{
							var inputs = $(this).parent().parent().parent().find("INPUT:not(:disabled)");	
							
								if($(this).is(":checked") == true)
								{
									inputs.each
									(
										function(index, element)
										{
										$(this).attr("checked", true);
										$(this).get(0).checked = true;
										}
									);
								}
								else
								{
									inputs.each
									(
										function(index, element)
										{
										$(this).attr("checked", false);
										$(this).get(0).checked = false;
										}
									);	
								}
							}
						}
						else
						{
							if($(this).is(":disabled") == false)
							{
							var input = $(this).parent().parent().parent().find("INPUT[name$='[isRead]']:not(:disabled)");		
							
								if(input.length)
								{
									if($(this).is(":checked") == true)
									{
									input.attr("checked", true);
									input.get(0).checked = true;
									}
								}
							}
						}
					}
				);	
			}
		},
		isSelectAll: function()
		{
		var status = true;
				
			$("#" + this.id + " INPUT").each
			(
				function()
				{				
					if($(this).get(0).disabled == false && $(this).get(0).checked == false) status = false;
				}
			);
			
		return status;
		},
		reset: function()
		{
			$("#" + this.id + " INPUT").each
			(
				function()
				{
				$(this).get(0).checked = false;
				$(this).attr("checked", false);
				}
			);
		},
		getValues: function()
		{
		var values = {};
		
			$("#" + this.id + " INPUT").each
			(
				function()
				{
				values[$(this).attr("name")] = $(this).get(0).checked == true ? 1 : 0;
				}
			);
			
		return values;	
		},
		initComponent: function()
		{
			this.store = 
			{
			type: "User.store.AdminSectionSelect",
			groupField: 'bundle'	
			};
		
		this.callParent();	
		}
	}
);