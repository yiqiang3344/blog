mermaid流程图源码格式
```mermaid
%%注释
graph LR
  PS[流程图顺序:<div style=text-align:left>TB:从上到下</br>BT:从下到上</br>RL:从右到左</br>LR:从左到右</br>TD:同TB</br></div>]

  A[方形] -->B(圆角)
  B --> C{条件a}
  C ---|a=1| D>结果1]
  C -.-|a=2| E((结果2))
  D -.-> F[bingo]
  E --描述--- F
  F -.描述.-> G
  G --描述--> G1
  G1 ==描述==> G2
  subgraph 子流程图1
  G2 --> G3
  end

	%%定义样式
  style PS fill:#ccc
  style G3 fill:#ccf,stroke:#f66,stroke-width:2px,stroke-dasharray: 10,5

	%%图标
  B1["fa:fa-twitter twitter图标"]
  B1-->C1[fa:fa-ban 禁止图标]
  B1-->D1(fa:fa-spinner 加载中);
  B1-->E1(fa:fa-camera-retro 相机);
```

flow流程图源码格式
```flow
st=>start: 开始框
op=>operation: 处理框
cond=>condition: 判断框(是或否?)
sub1=>subroutine: 子流程
io=>inputoutput: 输入输出框
e=>end: 结束框
st->op->cond
cond(yes)->io->e
##方向不能随意控制，有一定限制
cond(no)->sub1(top)->op
```

sequence时序图源码样例
```sequence
##注释
对象A->对象B: 对象B你好吗?（请求）
Note right of 对象B: 对象B的描述
Note left of 对象A: 对象A的描述(提示)
对象B-->对象A: 我很好(响应)
对象A->对象B: 你真的好吗？
```

sequence时序图源码复杂样例
```sequence
Title: 标题：复杂使用
对象A->对象B: 对象B你好吗?（请求）
Note right of 对象B: 对象B的描述
Note left of 对象A: 对象A的描述(提示)
对象B-->对象A: 我很好(响应)
对象B->小三: 你好吗
小三-->>对象A: 对象B找我了
对象A->对象B: 你真的好吗？
Note over 小三,对象B: 我们是朋友
participant C
Note right of C: 没人陪我玩
```

mermaid时序图样例
```mermaid
%% -> 直线，-->虚线，-->虚线箭头，->>实线箭头
sequenceDiagram
  participant 张三
  participant 李四
  participant 王五
  张三->>王五: 王五你好吗？
  loop 健康检查
  王五->>王五: 与疾病战斗
  end
  Note right of 王五: 合理 食物 <br/>看医生...
  李四-->>张三: 很好!
  王五->>李四: 你怎么样?
  李四-->>王五: 很好!
```

mermaid甘特图样例
```mermaid
%% 语法示例
gantt
  dateFormat  YYYY-MM-DD
  title 软件开发甘特图
  section 设计
    需求 :done, des1, 2014-01-06, 2014-01-08
    原型 :active, des2, 2014-01-09, 3d
    UI设计 : des3, after des2, 5d
    未来任务 : des4, after des3, 5d
  section 开发
    学习准备理解需求 :crit, done, 2014-01-06,24h
    设计框架 :crit, done, after des2, 2d
    开发 :crit, active, 3d
    未来任务 :crit, 5d
    耍 :2d
  section 测试
    功能测试 :active, a1, after des3, 3d
    压力测试 : after a1  , 20h
    测试报告 : 48h
```

mermaid类图
```mermaid
classDiagram
Class01 <|-- AveryLongClass : Cool
Class03 *-- Class04
Class05 o-- Class06
Class07 .. Class08
Class09 --> C2 : Where am i?
Class09 --* C3
Class09 --|> Class07
Class07 : equals()
Class07 : Object[] elementData
Class01 : size()
Class01 : int chimp
Class01 : int gorilla
Class08 <--> C2: Cool label
```

mermaid Git分支流
```mermaid
gitGraph:
options
{
    "nodeSpacing": 150,
    "nodeRadius": 10
}
end
commit
branch newbranch
checkout newbranch
commit
commit
checkout master
commit
commit
merge newbranch
```
