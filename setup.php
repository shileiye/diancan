<?php
// ��ʽ������
function weekday($datetime)
{
    $weekday  = date('w', strtotime($datetime));
    $weeklist = array('��', 'һ', '��', '��', '��', '��', '��');
    return '����' . $weeklist[$weekday];
}
?>