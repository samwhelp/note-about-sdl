

## Link

* https://zh.wikipedia.org/zh-tw/SDL
* https://en.wikipedia.org/wiki/Simple_DirectMedia_Layer


## Prepare

``` sh
$ sudo apt-get install build-essential libsdl2-dev
```


## pkg-config

run

``` sh
$ pkg-config --list-all | grep sdl -i
```

show

```
sdl2                           sdl2 - Simple DirectMedia Layer is a cross-platform multimedia library designed to provide low level access to audio, keyboard, mouse, joystick, 3D hardware via OpenGL, and 2D video framebuffer.
```

run

``` sh
$ pkg-config --cflags --libs sdl2
```

show

```
-D_REENTRANT -I/usr/include/SDL2 -lSDL2
```

## sdl2-config

run

``` sh
sdl2-config --cflags --libs
```

show

```
-I/usr/include/SDL2 -D_REENTRANT
-lSDL2
```

