<?php
$prize = '[
{"id":1,"min":1,"max":29,"prize":"一等奖","PR":1},
{"id":2,"min":302,"max":328,"prize":"二等奖","PR":2},
{"id":3,"min":242,"max":268,"prize":"三等奖","PR":5},
{"id":4,"min":182,"max":208,"prize":"四等奖","PR":7},
{"id":5,"min":122,"max":148,"prize":"五等奖","PR":10},
{"id":6,"min":62,"max":88,"prize":"六等奖","PR":25},
{"id":7,"min":[32,92,152,212,272,332],"max":[58,118,178,238,298,358],"prize":"七等奖","PR":50}
]';

function spinWin($prize) {
	# code...
	function getPrize($prize) {
		//用来保存中奖结果
		$result = array();

		//生成奖品的 id=>概率 数组$arr
		$prize_arr = json_decode($prize, true);
		foreach ($prize_arr as $key => $val) {
			$arr[$val['id']] = $val['PR'];
		}

		//根据概率获取奖项id
		$rid = getRand($arr);

		//提取中奖项
		$res = $prize_arr[$rid - 1];
		////保存中奖项的奖品到中奖结果
		$result['prize'] = $res['prize'];

		////保存中奖项的角度到中奖结果
		//中奖项的角度范围
		$min = $res['min'];
		$max = $res['max'];

		//如果是七等奖，将获得角度范围组，6选其1的随机获取角度范围；否则直接返回角度范围
		if ($res['id'] == 7) {
			$i = mt_rand(0, 5);
			$result['angle'] = mt_rand($min[$i], $max[$i]);
		} else {
			$result['angle'] = mt_rand($min, $max); //随机生成一个角度
		}

		//返回中奖结果
		return $result;
	}

	function getRand($proArr) {
		# code...
		$result = '';

		//概率数组的总概率精度
		$proSum = array_sum($proArr);

		//概率数组循环
		foreach ($proArr as $key => $proCur) {
			$randNum = mt_rand(1, $proSum);
			if ($randNum <= $proCur) {
				# code...
				$result = $key;
				break;
			} else {
				$proSum -= $proCur;
			}
		}

		//删除本次传入的概率数组
		unset($proArr);

		//返回奖品id
		return $result;
	}

	//输出json格式化的中奖信息
	echo json_encode(getPrize($prize));

}
spinWin($prize);
?>