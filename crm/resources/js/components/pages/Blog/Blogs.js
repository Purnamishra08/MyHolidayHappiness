import React, { useCallback,useEffect,useState,useRef  } from 'react';
import { connect } from 'react-redux';
import GlobalBody from "../GlobalBody";
import { Button, Checkbox, Form, Input,Col, Row, Card, Table, message, Divider,Skeleton,Popconfirm   } from 'antd';
import { AiOutlinePlus,AiOutlineEdit,AiFillDelete } from "react-icons/ai";
import { SearchOutlined,UndoOutlined,EyeFilled,EyeInvisibleFilled,HighlightFilled,HighlightOutlined} from '@ant-design/icons';
import {Link} from 'react-router-dom';
import API from "../../api/API";
import cookie from 'react-cookies';
import { useNavigate } from 'react-router-dom';
import Highlighter from 'react-highlight-words';

const onChange = (pagination, filters, sorter, extra) => {
  console.log('params', pagination, filters, sorter, extra);
};
export const Blogs = (props) => {
    const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [data, setData] = useState([]);
  

  const searchInput = useRef(null);
  const [searchText, setSearchText] = useState('');
  const [searchedColumn, setSearchedColumn] = useState('');
  const handleSearch = (selectedKeys, confirm, dataIndex) => {
    confirm();
    setSearchText(selectedKeys[0]);
    setSearchedColumn(dataIndex);
  };
  const handleReset = (clearFilters) => {
    clearFilters();
    setSearchText('');
  };
  const getColumnSearchProps = (dataIndex) => ({
      filterDropdown: ({ setSelectedKeys, selectedKeys, confirm, clearFilters }) => (
        <Row
          style={{
            padding: 8,
          }}
        >
         <Col span={20} >
          <Input
            ref={searchInput}
            placeholder={`Search ${dataIndex}`}
            value={selectedKeys[0]}
            onChange={(e) => setSelectedKeys(e.target.value ? [e.target.value] : [])}
            onPressEnter={() => handleSearch(selectedKeys, confirm, dataIndex)}
            style={{
              marginBottom: 8,
              display: 'block',
            }}
          />
          </Col>
         <Col span={4} >
            <UndoOutlined onClick={() => { handleReset(clearFilters); confirm({closeDropdown: false});setSearchText(selectedKeys[0]); setSearchedColumn(dataIndex); }} size="small" style={{ marginLeft: 10 }}/>
          </Col>
        </Row>
      ),
      filterIcon: (filtered) => (
        <SearchOutlined
          style={{
            color: filtered ? '#1890ff' : undefined,
          }}
        />
      ),
      onFilter: (value, record) =>
        record[dataIndex].toString().toLowerCase().includes(value.toLowerCase()),
      onFilterDropdownVisibleChange: (visible) => {
        if (visible) {
          setTimeout(() => searchInput.current?.select(), 100);
        }
      },
      render: (text) =>
        searchedColumn === dataIndex ? (
          <Highlighter
            highlightStyle={{
              backgroundColor: '#ffc069',
              padding: 0,
            }}
            searchWords={[searchText]}
            autoEscape
            textToHighlight={text ? text.toString() : ''}
          />
        ) : (
          text
        ),
    });




 const columns = [
  {
    title: 'ID',
    dataIndex: 'id',
    sorter: {
      compare: (a, b) => a.id - b.id,
      
    },
  },
  {
    title: 'Title',
    dataIndex: 'title',
    sorter: {
      compare: (a, b) => a.title.localeCompare(b.title),
      
    },
    ...getColumnSearchProps('title'),
  },{
    title: 'Category',
    dataIndex: 'category',
    sorter: {
      compare: (a, b) => a.category.localeCompare(b.category),
      
    },
    ...getColumnSearchProps('category'),
  }, {
    title: 'Sub Categories',
    dataIndex: 'sub_categories',
    sorter: {
      compare: (a, b) => a.sub_categories.localeCompare(b.sub_categories),
      
    },
    ...getColumnSearchProps('sub_categories'),
  }, {
    title: 'User Name',
    dataIndex: 'name',
    sorter: {
      compare: (a, b) => a.name.localeCompare(b.name),
      
    },
    ...getColumnSearchProps('name'),
  },
   {
      title: 'Action',
      dataIndex: '',
      key: 'x',
      render: (data) =>(<>  
                          <Link to={API.defaults.frontURL+`/editBlog?id=${data.id}`}>
                            <AiOutlineEdit style={{'marginRight':'10px'}}/>
                          </Link>
                          { (data.status==2 || data.status==0) ?
                           
                             <EyeFilled style={{'marginRight':'10px','cursor':'pointer','color':'blue'}}  onClick={()=>enableBlog(data.id)}/>
                         :
                             <EyeInvisibleFilled style={{'marginRight':'10px','cursor':'pointer','color':'blue'}}  onClick={()=>disableBlog(data.id)}/>
                           }
                           { (data.highlighted==0) ?
                           <HighlightOutlined style={{'marginRight':'10px','cursor':'pointer','color':'blue'}} onClick={()=>highlightBlog(data.id)} />
                         : <HighlightFilled style={{'marginRight':'10px','cursor':'pointer','color':'blue'}} onClick={()=>unHighlightBlog(data.id)} />
                           
                           }
                         
                         
                          <Popconfirm title="Are you sure to delete?" onConfirm={()=>removeBlog(data.id)}>
                             <AiFillDelete style={{'cursor':'pointer','color':'red'}}/> 
                          </Popconfirm>
                       </>),
    },
];
const highlightBlog=(id)=>{
      const hide = message.loading('Loading', 0);
      API.post('/highlightBlog',{'id':id})
                  .then(response=>{
                     setTimeout(hide, 0);
                    if(response.data.status){
                        setData(response.data.blogs.map(row => ({
                                  key: row.id,
                                  id: row.id,
                                  name: row.name,
                                  status:row.status,
                                  title:row.title,
                                  category:row.category,
                                  highlighted:row.highlighted,
                                  sub_categories:row.sub_categories.join(),
                                })));
                    }    
                  });
     }
     const unHighlightBlog=(id)=>{
      const hide = message.loading('Loading', 0);
      API.post('/unHighlightBlog',{'id':id})
                  .then(response=>{
                     setTimeout(hide, 0);
                    if(response.data.status){
                        setData(response.data.blogs.map(row => ({
                                  key: row.id,
                                  id: row.id,
                                  name: row.name,
                                  status:row.status,
                                  title:row.title,
                                  category:row.category,
                                  highlighted:row.highlighted,
                                  sub_categories:row.sub_categories.join(),
                                })));
                    }    
                  });
     }
  const enableBlog=(id)=>{
      const hide = message.loading('Loading', 0);
      API.post('/enableBlog',{'id':id})
                  .then(response=>{
                     setTimeout(hide, 0);
                    if(response.data.status){
                        setData(response.data.blogs.map(row => ({
                                  key: row.id,
                                  id: row.id,
                                  name: row.name,
                                  status:row.status,
                                  title:row.title,
                                  category:row.category,
                                  highlighted:row.highlighted,
                                  sub_categories:row.sub_categories.join(),
                                })));
                    }    
                  });
     }
     const disableBlog=(id)=>{
      const hide = message.loading('Loading', 0);
      API.post('/disableBlog',{'id':id})
                  .then(response=>{
                     setTimeout(hide, 0);
                    if(response.data.status){
                        setData(response.data.blogs.map(row => ({
                                  key: row.id,
                                  id: row.id,
                                  name: row.name,
                                  status:row.status,
                                  title:row.title,
                                  category:row.category,
                                  highlighted:row.highlighted,
                                  sub_categories:row.sub_categories.join(),
                                })));
                    }    
                  });
     }
  const removeBlog=(id)=>{
      const hide = message.loading('Deleting', 0);
      API.post('/removeBlog',{'id':id})
                  .then(response=>{
                     setTimeout(hide, 0);
                    if(response.data.status){
                        setData(response.data.blogs.map(row => ({
                                  key: row.id,
                                  id: row.id,
                                  name: row.name,
                                  status:row.status,
                                  title:row.title,
                                  category:row.category,
                                  highlighted:row.highlighted,
                                  sub_categories:row.sub_categories.join(),
                                })));

                    }    
                  });

  }
  const userDetails=cookie.load('userDetails');
  useEffect(() => {
         if(!userDetails){
           navigate(API.defaults.frontURL+'/login');
         }

         
         setLoading(true);
        const hide = message.loading('Loading', 0);
        
            API.post('/getBlogs')
                  .then(response=>{
                     setTimeout(hide, 0);
                     setLoading(false);
                    if(response.data.status){
                        setData(response.data.blogs.map(row => ({
                                  key: row.id,
                                  id: row.id,
                                  name: row.name,
                                  status:row.status,
                                  title:row.title,
                                  category:row.category,
                                  highlighted:row.highlighted,
                                  sub_categories:row.sub_categories.join(),
                                })));

                    }    
                  });
        }, [])



        return (
              <>
                <GlobalBody>
                  <h2>Blogs </h2>
                   <Divider orientation="right">
                  
                    <Link to={API.defaults.frontURL+'/addBlog'}>
                        <Button type="primary" shape="round" icon={<AiOutlinePlus style={{'marginTop':'-5%'}}/>} size={'Default'}> <span style={{'marginLeft':'5px'}}>Add new Blog</span>
                        </Button>
                    </Link>
                   </Divider>
                   {loading ?  <Skeleton />:   <Table columns={columns} dataSource={data}  onChange={onChange}  /> }
                  
                </GlobalBody>
              </>
          )

}


const mapStateToProps = (state) => ({})

export default connect(mapStateToProps, {})(Blogs)