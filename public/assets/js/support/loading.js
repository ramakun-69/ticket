function buildLoading(width,height,border_width = 3){
    return `<span class="spinner-border text-primary" data-borderwidth="${border_width}" style="width:${width};height:${height}"></span>`;
}
function buildLoadingWhite(width,height,border_width = 3){
    return `<span class="spinner-border text-white" data-borderwidth="${border_width}" style="width:${width};height:${height}"></span>`;
}
