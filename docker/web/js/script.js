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
    } else if (sortIconClassList.contains('fa-sort-down')) {
        sortIconClassList.replace('fa-sort-down', 'fa-sort-up');
    } else {
        sortIconClassList.replace('fa-sort-up', 'fa-sort');
    }
}

function menuClick() {
    const menuIconClassList = document.getElementById('menu-icon').classList;
    menuIconClassList.toggle('fa-xmark');
    menuIconClassList.toggle('fa-bars');
    document.getElementById('menu-content').classList.toggle('hide');
}

function openModal(id) {
    document.getElementById(id).classList.remove('hide');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hide');
}

function setPostId(event) {
    const seqNo = event.dataset.target;

    const input = document.createElement('input');
    input.setAttribute('name', 'seq_no');
    input.setAttribute('form', 'delete');
    input.setAttribute('value', seqNo);
    input.setAttribute('type', 'hidden');

    const text = document.createElement('p');
    text.prepend(`No.${seqNo}の投稿を削除してよろしいですか？`);

    let dialog = document.getElementById('delete-dialog');
    dialog.prepend(text);
    dialog.prepend(input);
    openModal('delete-dialog');
}

function setPostData(event) {
    const seq_no = event.dataset.seqNo;
    const post_title = event.dataset.title;
    const post_content = event.dataset.content;

    const input = document.createElement('input');
    input.setAttribute('name', 'seq_no');
    input.setAttribute('form', 'edit');
    input.setAttribute('value', seq_no);
    input.setAttribute('type', 'hidden');

    const title = document.getElementById('edit-title');
    title.setAttribute('value', post_title);

    const content = document.getElementById('edit-content');
    content.value = post_content;

    let dialog = document.getElementById('delete-dialog');
    dialog.prepend(input);
    openModal('edit-modal');
}

function setPostIds() {
    let inputList = document.getElementsByClassName('check');
    inputList = Array.from(inputList);
    inputList = inputList.filter((item) => item.checked);
    inputList = inputList.map((item) => item.value);
    const ids = inputList.join(',');

    const text = document.createElement('p');
    text.prepend(`No.${ids}の投稿を削除してよろしいですか？`);

    let dialog = document.getElementById('delete-bulk-dialog');
    dialog.prepend(text);
    openModal('delete-bulk-dialog');
}

function chnageCheckbox() {
    let checkList = document.getElementsByClassName('check');
    checkList = Array.from(checkList);
    checkList = checkList.filter((item) => item.checked);
    const deleteButton = document.getElementById('bulk-delete');
    if (checkList.length > 0) {
        deleteButton.removeAttribute('disabled');
    } else {
        deleteButton.setAttribute('disabled', true);
    }
}