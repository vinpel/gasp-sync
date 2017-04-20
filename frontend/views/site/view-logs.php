<?php
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\LogRequest;
$dataProvider = new ActiveDataProvider([
  'query' => LogRequest::find(),
  'pagination' => [
    'pageSize' => 20,
  ],
]);
$dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];
echo GridView::widget([
  'dataProvider' => $dataProvider,
  'columns' => [
    'created_at:datetime',
    'url:url',
    'method',
    [
      'attribute'=>'header_json',
      'format'=>'html',
      'value' => function ($data) {
        $args=['headers_json','raw_body','body_params'];
        $ret='';
        foreach ($args as $nom){
          if (strlen($data[$nom])>0){
            $arr=json_decode($data[$nom],true);
            $ret.=$nom.' :<pre>';
            if (is_array($arr)){
              foreach ($arr as $uneLigne){
                $ret.=implode(str_split($uneLigne,80),"...\n")."\n";
              }
            }else {
              $ret.=$data[$nom];
            }
            $ret.='</pre>';
          }
        }
        return $ret;
      },
    ]
  ]
]);
