<?php 
/**
 * Created by PhpStorm.
 * User: ���
 * Date: 2016/7/27
 * Time: 10:36
 * ���ṹ ����������� PHP �ݹ��㷨
 */


class IdiomSalon extends CI_Controller
{
	//�������������
    public function index(){
        echo json_encode($this->idiom('һ��һ��', 1));
    }

    //��������ݹ��㷨�����ܻ���ѭ�� $deep �������   $wide ������� ��ֹ��ѭ��
    public function idiom($word,$deep){
        if($deep>2)
            return array();

        $data = $this->db->where("����<>'{$word}'")->get("����",0,10)->result_array();
        $child = array();
        $wide = 0;
        foreach($data as $item){
            if($this->matchIdiom($word, $item['����'])){
                $wide ++;
                $child[] = $this->idiom($item['����'], $deep+1);
            }
            if($wide > 1)
                break;
        }
        $tree['word'] = $word;
        $tree['node'] = $child;
        return $tree;
    }

    //��������ж��Ƿ���Խ���
    public function matchIdiom($pre, $last){
        if(mb_substr($pre, -1) == mb_substr($last, 0, 1))
            return true;
        return false;
    }
	
	//�� �㷨 ���Գ���
    public function test(){
        $num = rand(0,2);
        $child = array();
        for($i = 0; $i < $num; $i++){
            $child[] = $this->test();
        }
        $tree['num'] = rand(500, 999);
        $tree['node'] = $child;
        return $tree;
    }
}
