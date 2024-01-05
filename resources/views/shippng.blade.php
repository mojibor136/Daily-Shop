@include('layouts.header')
@extends('layouts.navbar')

@section('name')
    Checkout
@endsection

<link rel="stylesheet" href="{{ asset('remixicon/remixicon.css') }}">
<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">

<style>
    /* Reset styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Body styles */
    body {
        background: #e7e8ec;
    }

    /* Navigation styles */
    nav {
        background-color: #dc3545;
        width: 100%;
        padding: 8px 30px 8px 30px;
        display: flex;
        justify-content: space-between;
        display: none;
    }

    nav .button {
        display: flex;
        align-items: center;
        color: #fff;
        font-weight: 400;
        cursor: pointer;
    }

    /* Form styles */
    form {
        padding: 0;
    }

    /* Main container styles */
    main {
        display: flex;
    }

    /* Order form styles */
    main .order-form {
        width: 60%;
        background-color: #fff;
        border-radius: 5px;
        padding: 20px;
        height: fit-content;
    }

    .form-control {
        margin-top: 2px;
    }

    main .order-form h4 {
        text-align: center;
    }

    main .order-form .form-group {
        margin: 5px 0;
    }

    /* Order content container styles */
    .order-content-container {
        margin: 0 10px;
        width: 40%;
    }

    /* Order content styles */
    main .order-content {
        width: 100%;
        height: fit-content;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
    }

    main .order-content table> :not(caption)>*>* {
        padding: 10px 5px;
    }

    main .order-content table thead tr th {
        font-size: 12px;
    }

    main .order-content table tbody tr td {
        text-transform: capitalize;
        font-size: 14px;
    }

    main .order-content table tbody tr td p {
        margin: 0;
        margin-left: 10px;
    }

    main .order-content table tbody tr td p span {
        font-weight: bold;
    }

    /* Summary styles */
    main .summary-ul {
        width: 100%;
        height: fit-content;
        padding: 20px;
        margin: 5px 0;
        background-color: #fff;
        border-radius: 5px;
    }

    main .summary-ul button {
        color: #fff;
        font-size: 16px;
        width: 100%;
        margin-top: 5px;
    }

    main .summary-ul h4 {
        font-size: 16px;
        color: #555666;
    }

    main .summary-ul .summary-li {
        display: flex;
        justify-content: space-between;
    }

    main .summary-ul .summary-li p {
        margin: 5px 0;
        font-size: 14px;
        color: #666666;
    }

    .btn-success {
        width: 100%;
        font-weight: bolder;
    }

    /* Place button bar styles */
    .place-button-bar {
        padding: 10px;
        padding-top: 5px;
        background-color: #fff;
        visibility: hidden;
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    .place-button-bar .total-bar {
        display: flex;
        align-items: center;
    }

    .place-button-bar .total-bar p {
        margin: 0;
    }

    .place-button-bar .total-bar .name {
        padding: 5px 0;
        text-transform: uppercase;
    }

    .place-button-bar .total-bar .price {
        color: rgb(255, 0, 149);
        padding: 5px;
        font-weight: 600;
    }

    .place-button-bar .total-bar .details-bar {
        display: flex;
        align-items: center;
        position: absolute;
        right: 15px;
    }

    .place-button-bar .total-bar .details-bar .arr {
        width: 9px;
        height: 9px;
        border-top: 2px solid;
        border-left: 2px solid;
        transform: rotate(-135deg);
        margin: 5px;
        margin-top: 0;
    }

    .place-button-bar .button {
        width: 100%;
    }

    .place-button-bar .button button {
        width: 100%;
        font-weight: 600;
    }

    /* Media queries for responsiveness */
    @media (max-width: 1280px) {
        main {
            margin: 2% 5%;
        }
    }

    @media (max-width: 1024px) {
        main {
            margin: 2% 4%;
        }
    }

    @media (max-width: 768px) {
        nav {
            padding: 5px 10px;
        }

        main {
            display: flex;
        }

        main .order-form {
            width: 100%;
        }

        .order-content-container {
            width: 100%;
        }

        main .order-content {
            margin-bottom: 15px;
        }

        main .order-content table tbody tr td {
            text-align: left;
        }
    }

    @media (max-width: 640px) {
        nav {
            display: inline-flex;
        }

        .order-content-container {
            margin: 10px 0;
            width: 100%;
        }

        main {
            display: flex;
            flex-direction: column;
            margin: 70px 10px 90px 10px;
        }

        main .order-content table thead tr th {
            font-size: 14px;
        }

        main .order-form {
            width: 100%;
            margin: 5px 0;
        }

        main .order-content {
            margin-bottom: 15px;
            padding: 10px 20px;
        }

        .summary-ul button {
            display: none;
        }

        .summary-ul #total-div {
            display: none;
        }

        .place-button-bar {
            visibility: visible;
        }

        .footer {
            display: none;
        }
    }

    @media (max-width: 475px) {
        /* Adjustments for smaller screens if needed */
    }

    @media (max-width: 320px) {
        main {
            margin-bottom: 75px;
        }

        .order-content-container {
            width: 100%;
            margin-bottom: 30px;
        }
    }
</style>

<body>
    <form action="{{ route('shipping.product') }}" method="POST">
        @csrf
        <main>
            <!-- ORDER FORM CUSTOMER DETAILS -->
            <div class="order-form">
                <h4>Add New Address</h4>
                <div class="form-group">
                    <label for="Name">Full Name</label>
                    <input type="text" class="form-control" placeholder="Enter your Name" name="name"
                        value="{{ old('name') }}">
                </div>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" placeholder="Enter your email" name="email"
                        value="{{ old('email') }}">
                </div>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="phone">Mobile Number</label>
                    <input type="phone" class="form-control" placeholder="Enter your phone number" name="number"
                        value="{{ old('number') }}">
                </div>
                @error('number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="">Division</label>
                    <select name="division" id="myDropdown" class="form-control">
                        <option disabled selected style="display:none;">Enter your Division</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Rangpur">Rangpur</option>
                    </select>
                </div>
                @error('division')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="">City</label>
                    <select name="city" id="myDropdown" class="form-control">
                        <option value="" disabled selected style="display:none;">Enter your City</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Rangpur">Rangpur</option>
                    </select>
                </div>
                @error('city')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="Address">Address</label>
                    <input type="address" class="form-control" placeholder="Enter your Address" name="address"
                        value="{{ old('address') }}">
                </div>
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- ORDER TABLE CONTENT SECTION -->
            <div class="order-content-container">
                <div class="order-content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>PRODUCT</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                                $delivery = 80;
                            @endphp
                            @foreach ($cartItems as $items)
                                <tr>
                                    <td class="align-middle" style="display: flex;">
                                        <img src="{{ asset('assets/img/product/images.jpeg') }}" alt=""
                                            width="40px" height="40px">
                                        <p>smart shirt smart shirt smart shirt <span>x{{ $items->quantity }}</span></p>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="align-middle">{{ $items->quantity * $items->product_price }}Tk</td>
                                </tr>
                                @php
                                    $price = $items->quantity * $items->product_price;
                                    $total = $total + $price;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- TOTAL SUMMARY PRICE SECTION -->
                <div class="summary-ul">
                    <h4>Total Summary</h4>
                    <div class="summary-li">
                        <p>Items Total</p>
                        <p>2</p>
                    </div>
                    <div class="summary-li">
                        <p>Delivery Fee</p>
                        <p style="text-transform: uppercase;">{{ $delivery }}tk</p>
                    </div>
                    <div class="summary-li">
                        <p>Total Payment</p>
                        <p style="text-transform: uppercase;">{{ $delivery + $total }}tk</p>
                    </div>
                    <div class="summary-li" id="total-div">
                        <p>Total</p>
                        <p style="text-transform: uppercase;">{{ $delivery + $total }}tk</p>
                    </div>
                    <button type="submit" class="btn btn-success">PLACE ORDER</button>
                </div>
            </div>
        </main>

        <!-- ORDER BUTTON SECTION -->
        <div class="place-button-bar">
            <div class="total-bar">
                <p class="name">Total:</p>
                <p class="price">{{ $delivery + $total }}Tk</p>
                <div class="details-bar">
                    <p>Details</p>
                    <div class="arr"></div>
                </div>
            </div>
            <div class="button">
                <button type="submit" class="btn btn-success">PLACE ORDER</button>
            </div>
        </div>
    </form>
    @include('layouts.footer')
</body>
