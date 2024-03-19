import React, { useState, useEffect, useRef } from 'react'
import FilterResults from 'react-filter-search'
import ReactDOM from 'react-dom'
import axios from 'axios'

let axiosHandler
export default function MobileSearchComponent() {
    const [showSearch, setShowSearch] = useState(false)
    const [searchText, setSearchText] = useState('')
    const [loading, setLoading] = useState(false)
    const [searchResults, setSearchResults] = useState([])
    const [products, setProducts] = useState([])
    const inputRef = useRef(null)

    useEffect(() => {
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

    useEffect(() => {
        if (showSearch) {
            inputRef.current && inputRef.current.focus()
        } else {
            setSearchText('')
        }
    }, [showSearch])

    const searchTextChange = (e) => {
        loading && axiosHandler.cancel()

        axiosHandler = axios.CancelToken.source()

        setSearchText(e.target.value)
        setLoading(true)
        axios.get(`/api/products/search/${e.target.value}`, {
            cancelToken: axiosHandler.token,
        }).then(response => {
            console.log(response)
            console.log(e.target.value)
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
        <div className="md:hidden py-3 pl-4 space-y-1 border-b border-gray-300">
            <div onClick={() => setShowSearch(true)} className="cursor-pointer hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out text-base font-medium text-gray-600 flex items-center">
                <i className="material-icons hover:text-blue-500" style={{ fontSize: 36 }}>
                    search
                </i>
                <p className="ml-3">Search Products</p>
            </div>
            {showSearch && <div className="fixed z-30 top-0 right-0 left-0 bottom-0 bg-white">
                <div className="flex items-center p-4">
                    <div className="relative cart-image flex-1 h-24">
                        <img src="/images/app-logo.png" alt="app-logo" />
                    </div>
                </div>

                <div className="text-xl italic mx-8 mt-2">
                    Search for products
                </div>
                <div className="flex items-center my-2 mx-8">
                    <input
                        ref={inputRef}
                        type="text"
                        placeholder="Start typing..."
                        className="flex-1 rounded"
                        value={searchText}
                        // onChange={searchTextChange}
                        onChange={e => setSearchText(e.target.value)}
                    />
                    <div onClick={() => setShowSearch(false)} className="ml-4 p-2 cursor-pointer text-2xl mx-2 text-gray-700 font-bold hover:text-blue-500">
                        X
                    </div>
                </div>

                <FilterResults
                    value={searchText}
                    data={products}
                    renderResults={searchResults =>
                        searchText && <div className="mt-2 mx-8 pverflow-y-auto overflow-x-hidden bg-white border border-gray-300 rounded shadow-md flex flex-col items-center" style={{ maxHeight: 500 }}>
                            {searchResults.length && searchText ?
                                searchResults.map((item, i) =>
                                    <a href={`/products/${item.id}`} key={i} className="w-full flex mx-2 border-t border-gray-200 items-center flex hover:bg-gray-100">
                                        <div className="relative cart-image flex-1 h-24">
                                            <img src={item.image} alt="prd_image" />
                                        </div>
                                        <div className="flex flex-col items-center justify-center text-center" style={{ flex: 2 }}>
                                            <p className="text-lg">{item.name}</p>
                                            <p className="text-lg">{item.type}</p>
                                            {/* <p className="text-lg">{item.price}</p> */}
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
            </div>}
        </div>
    )
}

if (document.getElementById('mobileSearch')) {
    ReactDOM.render(<MobileSearchComponent />, document.getElementById('mobileSearch'));
}