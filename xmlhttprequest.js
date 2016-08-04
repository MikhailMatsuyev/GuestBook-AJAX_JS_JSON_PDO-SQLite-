

function getXmlHttpRequest()
{

	if (window.XMLHttpRequest){
            try{
                alert('100');
                return new XMLHttpRequest();
            } catch (e){};
        }else if (window.ActiveXObject){
            try {
                return new ActiveXObject('Microsoft.XMLHTTP');
            }catch (e){}
        }
    return null;
}

