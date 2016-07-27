<?php 
/**
 * Created by PhpStorm.
 * User: 彭哥
 * Date: 2016/7/27
 * Time: 10:36
 * 树结构 成语接龙程序 PHP 递归算法
 */


class IdiomSalon extends CI_Controller
{
	//成语接龙主程序
    public function index(){
        echo json_encode($this->idiom('一心一意', 1));
    }

    //成语接龙递归算法，可能会死循环 $deep 锁定深度   $wide 锁定宽度 防止死循环
    public function idiom($word,$deep){
        if($deep>2)
            return array();

        $data = $this->db->where("成语<>'{$word}'")->get("成语",0,10)->result_array();
        $child = array();
        $wide = 0;
        foreach($data as $item){
            if($this->matchIdiom($word, $item['成语'])){
                $wide ++;
                $child[] = $this->idiom($item['成语'], $deep+1);
            }
            if($wide > 1)
                break;
        }
        $tree['word'] = $word;
        $tree['node'] = $child;
        return $tree;
    }

    //成语接龙判断是否可以接上
    public function matchIdiom($pre, $last){
        if(mb_substr($pre, -1) == mb_substr($last, 0, 1))
            return true;
        return false;
    }
	
	//树 算法 测试程序
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
