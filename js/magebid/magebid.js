function sendExportForm(form_name,url)
{		
		$(form_name).action = url;		
		$(form_name).submit();
}


