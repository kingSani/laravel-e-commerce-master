import React, { useState, useEffect, useRef } from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'

export default function CustomerCareComponent(props) {
    const [readyModal, setReadyModal] = useState(false)
    const [showModal, setShowModal] = useState(false)
    const [messages, setMessages] = useState([])
    const [message, setMessage] = useState('')
    const [active, setActive] = useState(0)
    const [noData, setNoData] = useState(false)
    const [users, setUsers] = useState([])
    const inputRef = useRef(null)

    useEffect(() => {
        axios.get('/api/users')
            .then(response => {
                if (response.data.length == 0) {
                    setNoData(true)
                    return
                }
                // setMessages(response.data)
                response.data.sort(function (a, b) {
                    if (a.chat.length == 0) {
                        if (b.chat.length == 0) {
                            return 0
                        }
                        return 1
                    }
                    
                    if (b.chat.length == 0) {
                        return -1
                    }

                    let aLatest = a.chat[a.chat.length - 1]
                    let bLatest = b.chat[b.chat.length - 1]
                    console.log(aLatest)
                    console.log(bLatest)
                    console.log(new Date(bLatest.updated_at).getTime() - new Date(aLatest.updated_at).getTime())
                    return new Date(bLatest.updated_at).getTime() - new Date(aLatest.updated_at).getTime()
                })
                console.log(response.data)
                setUsers(response.data)
                setActive(0)
                setMessages(response.data[0].chat)
            })

        Echo.private('chat')
            .listen('MessageSent', (e) => {
                console.log('recieved')
                setMessages([...messages, e.chat])
            });
    }, [])

    useEffect(() => {
        if (readyModal && !showModal) {
            setShowModal(true)
            inputRef.current && inputRef.current.focus()
        }
    }, [readyModal])

    useEffect(() => {
        if (readyModal && !showModal) {
            setTimeout(() => setReadyModal(false), 400)
        }
    }, [showModal])

    useEffect(() => {
        if (message == '') {
            let div = document.getElementsByClassName('message')
            if (div.length > 0) {
                div = div[div.length - 1]
                div.scrollIntoView({ behavior: 'smooth' })
            }
        }
    }, [messages])

    const changeUser = (index) => {
        setActive(index)
        setMessages(users[index].chat)
    }

    const sendMessage = () => {
        let item = message
        item.trim()
        if (message.trim() == '') return
        axios.post('/api/chat', {
            'user_id': users[active].id,
            sender: 'admin',
            message
        })
            .then(response => {
                console.log(response.data);

            });
        setMessage('')
        setMessages([...messages, { sender: 'admin', message }])
    }

    return (
        <div>
            <div
                onClick={() => setReadyModal(true)}
                className="cursor-pointer transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-105 w-20 h-20 flex items-center justify-center bg-blue-500"
                style={{ borderRadius: 50 }}
            >
                <i
                    className="material-icons text-white"
                    style={{ fontSize: 36 }}>
                    chat
                </i>
            </div>
            {noData ?
                <div className=""></div> :
                <div className={`${readyModal ? 'flex items-center justify-center fixed top-0 right-0 left-0 bottom-0 bg-black bg-opacity-25' : 'hidden'}`}>
                    <div className={`h-4/5 w-1/3 flex flex-col bg-white shadow rounded opacity-0 transition duration-500 ease-in-out ${showModal ? 'opacity-100 translate-y-4' : ''}`}>

                        <div className="bg-blue-600 w-full flex justify-between items center border-b border-gray-200 px-6 py-2">
                            <p className="text-3xl text-white">Customer Care</p>
                            <div onClick={() => setShowModal(false)}
                                className="text-white cursor-pointer py-1 inline-block text-center px-3 border border-transparent rounded-md font-semibold hover:text-white text-xl uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                X
                            </div>
                        </div>
                        <div className="overflow-y-auto flex-1">
                            {readyModal &&
                                users.map((user, i) =>
                                    <div
                                        onClick={() => changeUser(i)}
                                        key={i}
                                        className={`flex border-b p-4 bg-gray-100 cursor-pointer transition duration-300 ease-in-out hover:bg-gray-300 ${active == i ? 'bg-gray-300' : ''}`}>
                                        <div className="text-2xl">{user.name}</div>
                                    </div>
                                )
                            }
                        </div>
                    </div>
                    <div
                        className={`bg-gray-200 flex flex-col items-center rounded shadow h-4/5 w-2/5 opacity-0 transition duration-500 ease-in-out ${showModal ? 'opacity-100 translate-y-4' : ''}`}
                    // style={{height: '80%'}}
                    >
                        {readyModal &&
                            <>
                                <div className="bg-blue-600 w-full flex justify-between items center border-b border-gray-200 px-6 py-2">
                                    <p className="text-3xl text-white">{users[active]?.name}</p>
                                    <div
                                        className="text-white cursor-pointer py-1 inline-block text-center px-3 opacity-0 border border-transparent font-semibold text-xl uppercase">
                                        X
                                    </div>
                                </div>
                                <div className="flex-1 overflow-y-auto w-full px-2 my-2">
                                    {
                                        messages.length > 0 ?
                                            messages.map((item, i) =>
                                                <div
                                                    key={i}
                                                    className={`message m-2 flex ${item.sender == 'user' ? 'justify-start' : 'justify-end'}`}
                                                >
                                                    <div
                                                        className={`px-4 py-2 text-lg text-white ${item.sender == 'user' ? 'rounded-r-lg rounded-tl-lg' : 'rounded-l-lg rounded-tr-lg'} bg-blue-500`}
                                                        style={{ maxWidth: '60%' }}
                                                    >
                                                        {item.message}
                                                    </div>
                                                </div>
                                            )
                                            : <div></div>
                                    }
                                </div>
                                <div className="w-full flex">
                                    <input
                                        ref={inputRef}
                                        type="text"
                                        placeholder="Start typing..."
                                        className={`flex-1 `}
                                        value={message}
                                        onKeyPress={e => e.key == 'Enter' && sendMessage()}
                                        onChange={e => setMessage(e.target.value)}
                                    />
                                    <div
                                        onClick={() => sendMessage()}
                                        className="cursor-pointer transition duration-200 transform hover:bg-blue-800 bg-blue-600 w-1/4 h-16 py-2 flex items-center justify-center"
                                    >
                                        <p className="font-bold text-white text-center">Send Message</p>
                                    </div>
                                </div>
                            </>
                        }
                    </div>
                </div>

            }
        </div>
    )
}

if (document.getElementById('adminCustomerCare')) {
    const element = document.getElementById("adminCustomerCare")
    const props = Object.assign({}, element.dataset)
    ReactDOM.render(<CustomerCareComponent {...props} />, element)
}
