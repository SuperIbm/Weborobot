Ext.define('User.view.UserRoleUpdateAdminSectionGrid', 
	{
    extend: 'User.view.UserRoleCreateAdminSectionGrid',
	alias: 'widget.User.view.UserRoleUpdateAdminSectionGrid',
	
		requires:
		[
		'User.view.UserRoleCreateAdminSectionGrid'
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
			dataIndex: 'labelSection',
			width: "12%",			
				renderer: function(val, x, rec)
				{
					if(rec.get("status") == "Не активен")
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isRead]' value='1' disabled='disabled' />";
					}
					else if(rec.get("isRead") == true)
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isRead]' value='1' checked='checked' />"
					}
					else if(rec.get("isRead") == false)
					{					
						if(Admin.getApplication().Access.has("role", "Администрирование") == true)
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
			dataIndex: 'labelSection',
			width: "12%",
			hideable: false,
				renderer: function(val, x, rec)
				{	
					if(rec.get("status") == "Не активен")
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isCreate]' value='1' disabled='disabled' />"
					}
					else if(rec.get("isCreate") == true)
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isCreate]' value='1' checked='checked' />"
					}
					else if(rec.get("isCreate") == false)
					{
						if(Admin.getApplication().Access.has("role", "Администрирование") == true)
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
			dataIndex: 'labelSection',
			width: "12%",
				renderer: function(val, x, rec)
				{							
					if(rec.get("status") == "Не активен")
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isUpdate]' value='1' disabled='disabled' />";
					}
					else if(rec.get("isUpdate") == true)
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isUpdate]' value='1' checked='checked' />"
					}
					else if(rec.get("isUpdate") == false)
					{
						if(Admin.getApplication().Access.has("role", "Администрирование") == true)
						{
						return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isUpdate]' value='1' />"
						}
						else
						{
						return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isUpdate]' value='1' disabled='disabled' />";
						}
					}
				}
			},
			{
			header: 'Удалять',
			dataIndex: 'labelSection',
			width: "12%",
				renderer: function(val, x, rec)
				{					
					if(rec.get("status") == "Не активен")
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isDestroy]' value='1' disabled='disabled' />"
					}
					else if(rec.get("isDestroy") == true)
					{
					return "<input type='checkbox' name='sections[" + rec.get("idAdminSection") + "][isDestroy]' value='1' checked='checked' />"
					}						
					else if(rec.get("isDestroy") == false)
					{
						if(Admin.getApplication().Access.has("role", "Администрирование") == true)
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
		]
	}
);