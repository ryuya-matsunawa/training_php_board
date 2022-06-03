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