<!DOCTYPE html>
<html>
<head>
    <title>Animation des Lettres</title>
    <style>
        p {
            color: #fff;
            font-family: Avenir Next, Helvetica Neue, Helvetica, Tahoma, sans-serif;
            font-size: 1em;
            font-weight: 700;
        }

        p span {
            display: inline-block;
            position: relative;
            transform-style: preserve-3d;
            perspective: 500;
            -webkit-font-smoothing: antialiased;
        }

        p span::before,
        p span::after {
            display: none;
            position: absolute;
            top: 0;
            left: -1px;
            transform-origin: left top;
            transition: all ease-out 0.4s;
            content: attr(data-text);
        }

        p span::before {
            z-index: 1;
            color: rgba(0,0,0,0.2);
            transform: scale(1.1, 1) skew(0deg, 20deg);
        }

        p span::after {
            z-index: 2;
            color: #6e5e60;
            text-shadow: -1px 0 1px #6e5e60, 1px 0 1px rgba(0,0,0,0.8);
            transform: rotateY(-40deg);
        }

        p span:hover::before {
            transform: scale(1.1, 1) skew(0deg, 5deg);
        }

        p span:hover::after {
            transform: rotateY(-10deg);
        }

        p span + span {
            margin-left: 0.05em;
        }

        @media (min-width: 20em) {
            p {
                font-size: 2em;
            }
            p span::before,
            p span::after {
                display: block;
            }
        }

        @media (min-width: 30em) {
            p {
                font-size: 3em;
            }
        }

        @media (min-width: 40em) {
            p {
                font-size: 5em;
            }
        }

        @media (min-width: 60em) {
            p {
                font-size: 8em;
            }
        }

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #6e5e60;
        }
    </style>
</head>
<body>
<p aria-label="CodePen">
    <span data-text="J">J</span>
    <span data-text="I">I</span>
    <span data-text="N">N</span>
    <span data-text="G">G</span>
    <span data-text="L">L</span>
    <span data-text="E">E</span>
    <span data-text="-">-</span>
    <span data-text="C">C</span>
    <span data-text="O">O</span>
    <span data-text="N">N</span>
    <span data-text="T">T</span>
    <span data-text="E">E</span>
    <span data-text="S">S</span>
    <span data-text="T">T</span>
</p>
</body>
</html>