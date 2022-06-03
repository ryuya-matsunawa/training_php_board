/**
 * バリデーションチェック
 * 
 * @param $this 入力された値
 */
function replaceStr($this) {
    let str=$this.value;
    let replaceStr = str.match(/[0-9a-zA-Z]/g).join('');
    $this.value=replaceStr;
}

function changeClass() {
    const sortIcon =  document.getElementById('sort-icon');
    const sortIconClassList =  sortIcon.classList;
    if (sortIconClassList.contains('fa-sort')) {
        sortIconClassList.replace('fa-sort', 'fa-sort-down');
        // posts.sort((a, b) => {
        //     if(a.post_date < b.post_date) return 1;
        //     if(a.post_date > b.post_date) return -1;
        //     return 0;
        // });
    } else if (sortIconClassList.contains('fa-sort-down')) {
        sortIconClassList.replace('fa-sort-down', 'fa-sort-up');
    } else {
        sortIconClassList.replace('fa-sort-up', 'fa-sort');
    }
    // $.ajax({
    //     url: '../php/posts.php',
    //     data: {
    //         action: 'test',
    //         posts: []
    //     },
    //     type: 'post'
    // }).then((res) => {
    //     debugger

    // });
}

function menuClick() {
    const menuIconClassList = document.getElementById('menu-icon').classList;
    menuIconClassList.toggle('fa-xmark');
    menuIconClassList.toggle('fa-bars');
    document.getElementById('menu-content').classList.toggle('hide');
}

function openPostModal() {
    document.getElementById('post-modal').classList.remove('hide');
}

function closePostModal() {
    document.getElementById('post-modal').classList.add('hide');
}