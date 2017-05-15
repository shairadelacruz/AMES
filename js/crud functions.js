function deleteData(o) {
    
    if (confirm('Are you sure you want to delete?')) {
         var p=o.parentNode.parentNode;
         p.parentNode.removeChild(p);
    } 
    else {
    
    }
    
}
