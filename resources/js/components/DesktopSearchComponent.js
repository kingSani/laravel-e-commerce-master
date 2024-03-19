import React, { useState, useEffect, useRef } from 'react'
import FilterResults from 'react-filter-search'
import ReactDOM from 'react-dom'
import axios from 'axios'

let axiosHandler
export default function DesktopSearchComponent() {

    const [active, setActive] = useState(false)
    const [searchText, setSearchText] = useState('')
    const [loading, setLoading] = useState(false)
    const [searchResults, setSearchResults] = useState([])
    const [products, setProducts] = useState([])
    const inputRef = useRef(null)

    useEffect (() => {
        setLoading(true)
        axios.get(`/api/products`)
        .then(response => {
            if (response.status == 200) {
                setProducts(response.data)
            }
            setLoading(false)
        }).catch(function (thrown) {
            console.log(thrown)
            setLoading(false)
        });
    }, [])

    const searchClicked = () => {
        if (!active) {
            setActive(true)
            inputRef.current && inputRef.current.focus()

        } else {
            setActive(false)
            setSearchText('')
        }
    }

    const searchTextChange = (e) => {
        loading && axiosHandler.cancel()

        axiosHandler = axios.CancelToken.source()

        setSearchText(e.target.value)
        setLoading(true)
        axios.get(`/api/products/search/${e.target.value}`, {
            cancelToken: axiosHandler.token,
        }).then(response => {
            if (response.status == 200) {
                setSearchResults(response.data)
            }
            setLoading(false)
        }).catch(function (thrown) {
            console.log(thrown)
            if (axios.isCancel(thrown)) {
                // console.log('cancel for ', e.target.value)
            } else {
                // handle error
            }
            setLoading(false)
        });
    }

    return (
        <div className="hidden md:flex items-center">
            <div className="relative">
                <input
                    ref={inputRef}
                    type="text"
                    placeholder="Start typing..."
                    className={`${active ? 'activeInput' : ''}`}
                    value={searchText}
                    // onChange={searchTextChange}
                    onChange={e => setSearchText(e.target.value)}
                />

                <FilterResults
                    value={searchText}
                    data={products}
                    renderResults={searchResults =>
                        searchText && <div className="absolute overflow-y-auto overflow-x-hidden left-0 right-0 mt-2 bg-white border border-gray-300 rounded shadow-md flex flex-col items-center" style={{maxHeight: 600}}>
                            {
                                searchResults.length && searchText ?
                                    searchResults.map((item, i) =>
                                        <a href={`/products/${item.id}`} key={i} className="w-full flex mx-2 border-t border-gray-200 items-center flex hover:bg-gray-100">
                                            <div className="relative cart-image flex-1 h-28">
                                                <img src={item.image} alt="prd_image" />
                                            </div>
                                            <div className="flex flex-col items-center justify-center text-center" style={{ flex: 2 }}>
                                                <p className="text-lg">{item.name}</p>
                                                <p className="text-lg">{item.type}</p>
                                                <p className="text-lg">{item.price}</p>
                                            </div>
                                        </a>
                                    ) :
                                    !loading &&
                                    <div className="w-full text-center text-gray-400 text-lg italic border-t border-gray-200 py-2">
                                        Sorry, item not found :(
                                    </div>
                            }
                        </div>
                    }
                />

            </div>
            {!active ?
                <i
                    onClick={searchClicked}
                    className="cursor-pointer material-icons ml-2 hover:text-blue-500"
                    style={{ fontSize: 36 }}>
                    search
                </i> :
                <p
                    onClick={searchClicked}
                    className="cursor-pointer text-2xl mx-2 text-gray-700 font-bold hover:text-blue-500">
                    X
                </p>
            }
        </div>
    )
}

if (document.getElementById('desktopSearch')) {
    ReactDOM.render(<DesktopSearchComponent />, document.getElementById('desktopSearch'));
}