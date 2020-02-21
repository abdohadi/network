/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/@babel/runtime/regenerator/index.js":
/*!**********************************************************!*\
  !*** ./node_modules/@babel/runtime/regenerator/index.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! regenerator-runtime */ "./node_modules/regenerator-runtime/runtime.js");


/***/ }),

/***/ "./node_modules/regenerator-runtime/runtime.js":
/*!*****************************************************!*\
  !*** ./node_modules/regenerator-runtime/runtime.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

var runtime = (function (exports) {
  "use strict";

  var Op = Object.prototype;
  var hasOwn = Op.hasOwnProperty;
  var undefined; // More compressible than void 0.
  var $Symbol = typeof Symbol === "function" ? Symbol : {};
  var iteratorSymbol = $Symbol.iterator || "@@iterator";
  var asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator";
  var toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function wrap(innerFn, outerFn, self, tryLocsList) {
    // If outerFn provided and outerFn.prototype is a Generator, then outerFn.prototype instanceof Generator.
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator;
    var generator = Object.create(protoGenerator.prototype);
    var context = new Context(tryLocsList || []);

    // The ._invoke method unifies the implementations of the .next,
    // .throw, and .return methods.
    generator._invoke = makeInvokeMethod(innerFn, self, context);

    return generator;
  }
  exports.wrap = wrap;

  // Try/catch helper to minimize deoptimizations. Returns a completion
  // record like context.tryEntries[i].completion. This interface could
  // have been (and was previously) designed to take a closure to be
  // invoked without arguments, but in all the cases we care about we
  // already have an existing method we want to call, so there's no need
  // to create a new function object. We can even get away with assuming
  // the method takes exactly one argument, since that happens to be true
  // in every case, so we don't have to touch the arguments object. The
  // only additional allocation required is the completion record, which
  // has a stable shape and so hopefully should be cheap to allocate.
  function tryCatch(fn, obj, arg) {
    try {
      return { type: "normal", arg: fn.call(obj, arg) };
    } catch (err) {
      return { type: "throw", arg: err };
    }
  }

  var GenStateSuspendedStart = "suspendedStart";
  var GenStateSuspendedYield = "suspendedYield";
  var GenStateExecuting = "executing";
  var GenStateCompleted = "completed";

  // Returning this object from the innerFn has the same effect as
  // breaking out of the dispatch switch statement.
  var ContinueSentinel = {};

  // Dummy constructor functions that we use as the .constructor and
  // .constructor.prototype properties for functions that return Generator
  // objects. For full spec compliance, you may wish to configure your
  // minifier not to mangle the names of these two functions.
  function Generator() {}
  function GeneratorFunction() {}
  function GeneratorFunctionPrototype() {}

  // This is a polyfill for %IteratorPrototype% for environments that
  // don't natively support it.
  var IteratorPrototype = {};
  IteratorPrototype[iteratorSymbol] = function () {
    return this;
  };

  var getProto = Object.getPrototypeOf;
  var NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  if (NativeIteratorPrototype &&
      NativeIteratorPrototype !== Op &&
      hasOwn.call(NativeIteratorPrototype, iteratorSymbol)) {
    // This environment has a native %IteratorPrototype%; use it instead
    // of the polyfill.
    IteratorPrototype = NativeIteratorPrototype;
  }

  var Gp = GeneratorFunctionPrototype.prototype =
    Generator.prototype = Object.create(IteratorPrototype);
  GeneratorFunction.prototype = Gp.constructor = GeneratorFunctionPrototype;
  GeneratorFunctionPrototype.constructor = GeneratorFunction;
  GeneratorFunctionPrototype[toStringTagSymbol] =
    GeneratorFunction.displayName = "GeneratorFunction";

  // Helper for defining the .next, .throw, and .return methods of the
  // Iterator interface in terms of a single ._invoke method.
  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function(method) {
      prototype[method] = function(arg) {
        return this._invoke(method, arg);
      };
    });
  }

  exports.isGeneratorFunction = function(genFun) {
    var ctor = typeof genFun === "function" && genFun.constructor;
    return ctor
      ? ctor === GeneratorFunction ||
        // For the native GeneratorFunction constructor, the best we can
        // do is to check its .name property.
        (ctor.displayName || ctor.name) === "GeneratorFunction"
      : false;
  };

  exports.mark = function(genFun) {
    if (Object.setPrototypeOf) {
      Object.setPrototypeOf(genFun, GeneratorFunctionPrototype);
    } else {
      genFun.__proto__ = GeneratorFunctionPrototype;
      if (!(toStringTagSymbol in genFun)) {
        genFun[toStringTagSymbol] = "GeneratorFunction";
      }
    }
    genFun.prototype = Object.create(Gp);
    return genFun;
  };

  // Within the body of any async function, `await x` is transformed to
  // `yield regeneratorRuntime.awrap(x)`, so that the runtime can test
  // `hasOwn.call(value, "__await")` to determine if the yielded value is
  // meant to be awaited.
  exports.awrap = function(arg) {
    return { __await: arg };
  };

  function AsyncIterator(generator) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);
      if (record.type === "throw") {
        reject(record.arg);
      } else {
        var result = record.arg;
        var value = result.value;
        if (value &&
            typeof value === "object" &&
            hasOwn.call(value, "__await")) {
          return Promise.resolve(value.__await).then(function(value) {
            invoke("next", value, resolve, reject);
          }, function(err) {
            invoke("throw", err, resolve, reject);
          });
        }

        return Promise.resolve(value).then(function(unwrapped) {
          // When a yielded Promise is resolved, its final value becomes
          // the .value of the Promise<{value,done}> result for the
          // current iteration.
          result.value = unwrapped;
          resolve(result);
        }, function(error) {
          // If a rejected Promise was yielded, throw the rejection back
          // into the async generator function so it can be handled there.
          return invoke("throw", error, resolve, reject);
        });
      }
    }

    var previousPromise;

    function enqueue(method, arg) {
      function callInvokeWithMethodAndArg() {
        return new Promise(function(resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise =
        // If enqueue has been called before, then we want to wait until
        // all previous Promises have been resolved before calling invoke,
        // so that results are always delivered in the correct order. If
        // enqueue has not been called before, then it is important to
        // call invoke immediately, without waiting on a callback to fire,
        // so that the async generator function has the opportunity to do
        // any necessary setup in a predictable way. This predictability
        // is why the Promise constructor synchronously invokes its
        // executor callback, and why async functions synchronously
        // execute code before the first await. Since we implement simple
        // async functions in terms of async generators, it is especially
        // important to get this right, even though it requires care.
        previousPromise ? previousPromise.then(
          callInvokeWithMethodAndArg,
          // Avoid propagating failures to Promises returned by later
          // invocations of the iterator.
          callInvokeWithMethodAndArg
        ) : callInvokeWithMethodAndArg();
    }

    // Define the unified helper method that is used to implement .next,
    // .throw, and .return (see defineIteratorMethods).
    this._invoke = enqueue;
  }

  defineIteratorMethods(AsyncIterator.prototype);
  AsyncIterator.prototype[asyncIteratorSymbol] = function () {
    return this;
  };
  exports.AsyncIterator = AsyncIterator;

  // Note that simple async functions are implemented on top of
  // AsyncIterator objects; they just return a Promise for the value of
  // the final result produced by the iterator.
  exports.async = function(innerFn, outerFn, self, tryLocsList) {
    var iter = new AsyncIterator(
      wrap(innerFn, outerFn, self, tryLocsList)
    );

    return exports.isGeneratorFunction(outerFn)
      ? iter // If outerFn is a generator, return the full iterator.
      : iter.next().then(function(result) {
          return result.done ? result.value : iter.next();
        });
  };

  function makeInvokeMethod(innerFn, self, context) {
    var state = GenStateSuspendedStart;

    return function invoke(method, arg) {
      if (state === GenStateExecuting) {
        throw new Error("Generator is already running");
      }

      if (state === GenStateCompleted) {
        if (method === "throw") {
          throw arg;
        }

        // Be forgiving, per 25.3.3.3.3 of the spec:
        // https://people.mozilla.org/~jorendorff/es6-draft.html#sec-generatorresume
        return doneResult();
      }

      context.method = method;
      context.arg = arg;

      while (true) {
        var delegate = context.delegate;
        if (delegate) {
          var delegateResult = maybeInvokeDelegate(delegate, context);
          if (delegateResult) {
            if (delegateResult === ContinueSentinel) continue;
            return delegateResult;
          }
        }

        if (context.method === "next") {
          // Setting context._sent for legacy support of Babel's
          // function.sent implementation.
          context.sent = context._sent = context.arg;

        } else if (context.method === "throw") {
          if (state === GenStateSuspendedStart) {
            state = GenStateCompleted;
            throw context.arg;
          }

          context.dispatchException(context.arg);

        } else if (context.method === "return") {
          context.abrupt("return", context.arg);
        }

        state = GenStateExecuting;

        var record = tryCatch(innerFn, self, context);
        if (record.type === "normal") {
          // If an exception is thrown from innerFn, we leave state ===
          // GenStateExecuting and loop back for another invocation.
          state = context.done
            ? GenStateCompleted
            : GenStateSuspendedYield;

          if (record.arg === ContinueSentinel) {
            continue;
          }

          return {
            value: record.arg,
            done: context.done
          };

        } else if (record.type === "throw") {
          state = GenStateCompleted;
          // Dispatch the exception by looping back around to the
          // context.dispatchException(context.arg) call above.
          context.method = "throw";
          context.arg = record.arg;
        }
      }
    };
  }

  // Call delegate.iterator[context.method](context.arg) and handle the
  // result, either by returning a { value, done } result from the
  // delegate iterator, or by modifying context.method and context.arg,
  // setting context.delegate to null, and returning the ContinueSentinel.
  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];
    if (method === undefined) {
      // A .throw or .return when the delegate iterator has no .throw
      // method always terminates the yield* loop.
      context.delegate = null;

      if (context.method === "throw") {
        // Note: ["return"] must be used for ES3 parsing compatibility.
        if (delegate.iterator["return"]) {
          // If the delegate iterator has a return method, give it a
          // chance to clean up.
          context.method = "return";
          context.arg = undefined;
          maybeInvokeDelegate(delegate, context);

          if (context.method === "throw") {
            // If maybeInvokeDelegate(context) changed context.method from
            // "return" to "throw", let that override the TypeError below.
            return ContinueSentinel;
          }
        }

        context.method = "throw";
        context.arg = new TypeError(
          "The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);

    if (record.type === "throw") {
      context.method = "throw";
      context.arg = record.arg;
      context.delegate = null;
      return ContinueSentinel;
    }

    var info = record.arg;

    if (! info) {
      context.method = "throw";
      context.arg = new TypeError("iterator result is not an object");
      context.delegate = null;
      return ContinueSentinel;
    }

    if (info.done) {
      // Assign the result of the finished delegate to the temporary
      // variable specified by delegate.resultName (see delegateYield).
      context[delegate.resultName] = info.value;

      // Resume execution at the desired location (see delegateYield).
      context.next = delegate.nextLoc;

      // If context.method was "throw" but the delegate handled the
      // exception, let the outer generator proceed normally. If
      // context.method was "next", forget context.arg since it has been
      // "consumed" by the delegate iterator. If context.method was
      // "return", allow the original .return call to continue in the
      // outer generator.
      if (context.method !== "return") {
        context.method = "next";
        context.arg = undefined;
      }

    } else {
      // Re-yield the result returned by the delegate method.
      return info;
    }

    // The delegate iterator is finished, so forget it and continue with
    // the outer generator.
    context.delegate = null;
    return ContinueSentinel;
  }

  // Define Generator.prototype.{next,throw,return} in terms of the
  // unified ._invoke helper method.
  defineIteratorMethods(Gp);

  Gp[toStringTagSymbol] = "Generator";

  // A Generator should always return itself as the iterator object when the
  // @@iterator function is called on it. Some browsers' implementations of the
  // iterator prototype chain incorrectly implement this, causing the Generator
  // object to not be returned from this call. This ensures that doesn't happen.
  // See https://github.com/facebook/regenerator/issues/274 for more details.
  Gp[iteratorSymbol] = function() {
    return this;
  };

  Gp.toString = function() {
    return "[object Generator]";
  };

  function pushTryEntry(locs) {
    var entry = { tryLoc: locs[0] };

    if (1 in locs) {
      entry.catchLoc = locs[1];
    }

    if (2 in locs) {
      entry.finallyLoc = locs[2];
      entry.afterLoc = locs[3];
    }

    this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal";
    delete record.arg;
    entry.completion = record;
  }

  function Context(tryLocsList) {
    // The root entry object (effectively a try statement without a catch
    // or a finally block) gives us a place to store values thrown from
    // locations where there is no enclosing try statement.
    this.tryEntries = [{ tryLoc: "root" }];
    tryLocsList.forEach(pushTryEntry, this);
    this.reset(true);
  }

  exports.keys = function(object) {
    var keys = [];
    for (var key in object) {
      keys.push(key);
    }
    keys.reverse();

    // Rather than returning an object with a next method, we keep
    // things simple and return the next function itself.
    return function next() {
      while (keys.length) {
        var key = keys.pop();
        if (key in object) {
          next.value = key;
          next.done = false;
          return next;
        }
      }

      // To avoid creating an additional object, we just hang the .value
      // and .done properties off the next function object itself. This
      // also ensures that the minifier will not anonymize the function.
      next.done = true;
      return next;
    };
  };

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) {
        return iteratorMethod.call(iterable);
      }

      if (typeof iterable.next === "function") {
        return iterable;
      }

      if (!isNaN(iterable.length)) {
        var i = -1, next = function next() {
          while (++i < iterable.length) {
            if (hasOwn.call(iterable, i)) {
              next.value = iterable[i];
              next.done = false;
              return next;
            }
          }

          next.value = undefined;
          next.done = true;

          return next;
        };

        return next.next = next;
      }
    }

    // Return an iterator with no values.
    return { next: doneResult };
  }
  exports.values = values;

  function doneResult() {
    return { value: undefined, done: true };
  }

  Context.prototype = {
    constructor: Context,

    reset: function(skipTempReset) {
      this.prev = 0;
      this.next = 0;
      // Resetting context._sent for legacy support of Babel's
      // function.sent implementation.
      this.sent = this._sent = undefined;
      this.done = false;
      this.delegate = null;

      this.method = "next";
      this.arg = undefined;

      this.tryEntries.forEach(resetTryEntry);

      if (!skipTempReset) {
        for (var name in this) {
          // Not sure about the optimal order of these conditions:
          if (name.charAt(0) === "t" &&
              hasOwn.call(this, name) &&
              !isNaN(+name.slice(1))) {
            this[name] = undefined;
          }
        }
      }
    },

    stop: function() {
      this.done = true;

      var rootEntry = this.tryEntries[0];
      var rootRecord = rootEntry.completion;
      if (rootRecord.type === "throw") {
        throw rootRecord.arg;
      }

      return this.rval;
    },

    dispatchException: function(exception) {
      if (this.done) {
        throw exception;
      }

      var context = this;
      function handle(loc, caught) {
        record.type = "throw";
        record.arg = exception;
        context.next = loc;

        if (caught) {
          // If the dispatched exception was caught by a catch block,
          // then let that catch block handle the exception normally.
          context.method = "next";
          context.arg = undefined;
        }

        return !! caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        var record = entry.completion;

        if (entry.tryLoc === "root") {
          // Exception thrown outside of any try block that could handle
          // it, so set the completion value of the entire function to
          // throw the exception.
          return handle("end");
        }

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc");
          var hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            } else if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            }

          } else if (hasFinally) {
            if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else {
            throw new Error("try statement without catch or finally");
          }
        }
      }
    },

    abrupt: function(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc <= this.prev &&
            hasOwn.call(entry, "finallyLoc") &&
            this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      if (finallyEntry &&
          (type === "break" ||
           type === "continue") &&
          finallyEntry.tryLoc <= arg &&
          arg <= finallyEntry.finallyLoc) {
        // Ignore the finally entry if control is not jumping to a
        // location outside the try/catch block.
        finallyEntry = null;
      }

      var record = finallyEntry ? finallyEntry.completion : {};
      record.type = type;
      record.arg = arg;

      if (finallyEntry) {
        this.method = "next";
        this.next = finallyEntry.finallyLoc;
        return ContinueSentinel;
      }

      return this.complete(record);
    },

    complete: function(record, afterLoc) {
      if (record.type === "throw") {
        throw record.arg;
      }

      if (record.type === "break" ||
          record.type === "continue") {
        this.next = record.arg;
      } else if (record.type === "return") {
        this.rval = this.arg = record.arg;
        this.method = "return";
        this.next = "end";
      } else if (record.type === "normal" && afterLoc) {
        this.next = afterLoc;
      }

      return ContinueSentinel;
    },

    finish: function(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) {
          this.complete(entry.completion, entry.afterLoc);
          resetTryEntry(entry);
          return ContinueSentinel;
        }
      }
    },

    "catch": function(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;
          if (record.type === "throw") {
            var thrown = record.arg;
            resetTryEntry(entry);
          }
          return thrown;
        }
      }

      // The context.catch method must only be called with a location
      // argument that corresponds to a known catch block.
      throw new Error("illegal catch attempt");
    },

    delegateYield: function(iterable, resultName, nextLoc) {
      this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      };

      if (this.method === "next") {
        // Deliberately forget the last sent value so that we don't
        // accidentally pass it on to the delegate.
        this.arg = undefined;
      }

      return ContinueSentinel;
    }
  };

  // Regardless of whether this script is executing as a CommonJS module
  // or not, return the runtime object so that we can declare the variable
  // regeneratorRuntime in the outer scope, which allows this module to be
  // injected easily by `bin/regenerator --include-runtime script.js`.
  return exports;

}(
  // If this script is executing as a CommonJS module, use module.exports
  // as the regeneratorRuntime namespace. Otherwise create a new empty
  // object. Either way, the resulting object will be used to initialize
  // the regeneratorRuntime variable at the top of this file.
   true ? module.exports : undefined
));

try {
  regeneratorRuntime = runtime;
} catch (accidentalStrictMode) {
  // This module should not be running in strict mode, so the above
  // assignment should always work unless something is misconfigured. Just
  // in case runtime.js accidentally runs in strict mode, we can escape
  // strict mode using a global Function call. This could conceivably fail
  // if a Content Security Policy forbids using Function, but in that case
  // the proper solution is to fix the accidental strict mode problem. If
  // you've misconfigured your bundler to force strict mode and applied a
  // CSP to forbid Function, and you're not willing to fix either of those
  // problems, please detail your unique predicament in a GitHub issue.
  Function("r", "regeneratorRuntime = r")(runtime);
}


/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

/**
* Our custom javascript & jquery
*/
$(document).ready(function () {
  var _this = this;

  /**
   *	Posts Section
   */
  // Show post options
  $(document).on('click', 'i.show-options', function () {
    $(this).siblings('div.options').fadeToggle(100);
    $('div.options').not($(this).parent().find('div.options')).fadeOut(100);
  }); // Hide post options when clicking anywhere

  $(document).click(function (e) {
    if (!e.target.classList.contains('show-options') && !e.target.classList.contains('options')) {
      $('div.options').fadeOut(100);
    }
  }); // Show post data in modal to edit the post

  $('.open-post-modal').click(function () {
    var post = $(this).data('post');
    $('.post-modal').find('textarea').text(post.body);

    if (window.location.pathname == '/' || window.location.pathname == '/home') {
      $('.post-modal').find('form').attr('action', '/posts/' + post.id);
    }
  }); // Show post errors when clicking submit button

  $('#submit-update-post, #submit-create-post').click(function (e) {
    var textarea = $(this).parents('form').find('textarea');

    if (textarea.val() == '') {
      textarea.addClass('border-red-300');
      textarea.siblings('.post-error').show();
      e.preventDefault();
    } else {
      textarea.removeClass('border-red-300');
      textarea.addClass('border-green-500');
      textarea.siblings('.post-error').hide();
    }
  }); // Redirect to post page when u click on it
  // $('.post').click(function (e) {
  // 	if (! $(this).data('in-show-page') && e.target.id != 'show-options' && e.target.id != 'post-options' && e.target.id != 'open-post-modal') {
  // 		window.location = $(this).data('post');
  // 	}
  // });

  /**
   *	Comments Section
   */
  // Focus on comment input

  $('.comment-span').on('click', function () {
    $(_this).parents('.post-box').find('.comment-input').focus();
  }); // Add comment

  $('.add-comment-form').on('submit', function (e) {
    e.preventDefault();
    var url = $(this).attr('action'),
        data = $(this).serializeArray().reduce(function (obj, item) {
      obj[item.name] = item.value;
      return obj;
    }, {});
    addComment($(this), data, url);
  }); // Show comment data in modal to edit the comment

  $(document).on('click', '.open-comment-modal', function () {
    var commentId = $(this).data('comment-id');
    var commentBody = $(this).parents('.user-comment').find('.comment-body').text();
    var postId = $(this).data('post-id');
    window.commentToEdit = $(this).parents('.user-comment').find('.comment-body');
    $('.comment-modal').find('textarea').val(commentBody);

    if (window.location.pathname == '/' || window.location.pathname == '/home') {
      $('.comment-modal').find('form').attr('action', "posts/".concat(postId, "/comments/").concat(commentId));
    }
  }); // Update comment

  $('.update-comment-form').on('submit', function (e) {
    e.preventDefault();
    var url = $(this).attr('action'),
        data = $(this).serializeArray().reduce(function (obj, item) {
      obj[item.name] = item.value;
      return obj;
    }, {});
    updateComment($(this), data, url);
  }); // Delete comment 

  $(document).on('click', '.delete-comment', function (e) {
    var _this2 = this;

    e.preventDefault();
    $.ajax({
      url: $(this).data('comment-url'),
      method: 'get',
      success: function success() {
        $(_this2).parents('.user-comment').remove();
      },
      error: function error(_error) {
        console.log('error');
      }
    });
  });
  /**
   *	Likes Section
   */
  // Like a post

  $('.like-post').on('click', handlePostLikes);
  /**
   *	Groups Section
   */
  // Show group errors when clicking submit button

  $('#submit-create-group').click(function (e) {
    var nameInput = $(this).parents('form').find('#name');
    var descriptionInput = $(this).parents('form').find('#description');

    if (nameInput.val() == '') {
      nameInput.addClass('border-red-300');
      nameInput.siblings('.group-error').show();
      e.preventDefault();
    } else {
      nameInput.removeClass('border-red-300');
      nameInput.addClass('border-green-500');
      nameInput.siblings('.group-error').hide();
    }

    if (descriptionInput.val() == '') {
      descriptionInput.addClass('border-red-300');
      descriptionInput.siblings('.group-error').show();
      e.preventDefault();
    } else {
      descriptionInput.removeClass('border-red-300');
      descriptionInput.addClass('border-green-500');
      descriptionInput.siblings('.group-error').hide();
    }
  });
  /**
   *	Friend Requests Section
   */
  // Friend requests event handler

  $('button#send_friend_request, button#cancel_friend_request, button#accept_friend_request, button#delete_friend_request').click(function (e) {
    e.preventDefault();
    handleFriendRequest(this);
  }); // Show friend requests menue

  $('#friend-requests-dropdown').css('top', $('nav').innerHeight());
  $('#show-friend-requests').click(function () {
    $(this).children('i#show-friend-requests').toggleClass('text-gray-700').toggleClass('text-primary');
    $(this).siblings('div#friend-requests-dropdown').toggle();
  }); // Hide friend requests menue when clicking anywhere except the menue

  $(document).click(function (e) {
    if (e.target.id == 'friend-requests-dropdown' || e.target.id == 'show-friend-requests') {
      return;
    }

    if (e.target.parentElement) {
      if (e.target.parentElement.id == 'friend-requests-dropdown' || e.target.parentNode.offsetParent.id == 'friend-requests-dropdown') {
        return;
      }
    }

    $('i#show-friend-requests').removeClass('text-primary').addClass('text-gray-700');
    $('div#friend-requests-dropdown').hide();
  });
  /**
   *	Login Section
   */
  // Login register card

  $('.create-account-button').click(function () {
    $(this).parents('.login-register').css({
      '-webkit-transform': 'rotateY(180deg)',
      '-moz-transform': 'rotateY(180deg)',
      '-o-transform': 'rotateY(180deg)',
      'transform': 'rotateY(180deg)'
    });
    $('.register-card').css('z-index', '2');
  });
  $('.have-account').click(function () {
    $(this).parents('.login-register').css({
      '-webkit-transform': 'rotateY(0)',
      '-moz-transform': 'rotateY(0)',
      '-o-transform': 'rotateY(0)',
      'transform': 'rotateY(0)'
    });
  }); // Show register card if a register request

  if ($('.register-card').data('request') == 'register-request') {
    $('.login-register').css({
      '-webkit-transform': 'rotateY(180deg)',
      '-moz-transform': 'rotateY(180deg)',
      '-o-transform': 'rotateY(180deg)',
      'transform': 'rotateY(180deg)'
    });
    $('.login-card form input[type=email]').val('');
  } // Hello there login page


  window.onload = function () {
    var container = document.querySelector('.hello-there'),
        text = "Hello there! You are gonna join my website now. I hope you keep silent here because it's not some kind of memes-website. It's ok to share memes but keep your fu*kin mouth shut up. Sorry, dude for my language and have fun",
        i = 0;

    if (container) {
      var writer = setInterval(function () {
        container.innerHTML += text[i++];

        if (text[i - 1] === '.') {
          container.innerHTML += '<br>';
        }

        if (i == text.length) {
          clearInterval(writer);
        }
      }, 100);
    }
  };
});
/**
* Functions
*/
// Send / cancel / delete / accept friend requests

function handleFriendRequest(_x) {
  return _handleFriendRequest.apply(this, arguments);
} // handle post likes


function _handleFriendRequest() {
  _handleFriendRequest = _asyncToGenerator(
  /*#__PURE__*/
  _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee(el) {
    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
      while (1) {
        switch (_context.prev = _context.next) {
          case 0:
            if (!($(el).attr('id') == 'send_friend_request')) {
              _context.next = 9;
              break;
            }

            // loader
            // $(el).html('<div class="lds-facebook"><div></div><div></div><div></div></div>');
            $(el).attr('class', 'button-outline-secondary ml-auto'); // send the request

            _context.next = 4;
            return $.get('/users/request/send/' + $(el).data('user-id'));

          case 4:
            $(el).attr('id', 'cancel_friend_request');
            $(el).attr('title', 'Click to cancel the request');
            $(el).html('<i class="fa fa-check"></i> Sent');
            _context.next = 30;
            break;

          case 9:
            if (!($(el).attr('id') == 'cancel_friend_request')) {
              _context.next = 18;
              break;
            }

            // $(el).html('<div class="lds-facebook"><div></div><div></div><div></div></div>');
            $(el).attr('class', 'button-outline-primary ml-auto');
            _context.next = 13;
            return $.get('/users/request/cancel/' + $(el).data('user-id'));

          case 13:
            $(el).attr('id', 'send_friend_request');
            $(el).attr('title', 'Click to send a friend request');
            $(el).html('<i class="fa fa-plus"></i> Add');
            _context.next = 30;
            break;

          case 18:
            if (!($(el).attr('id') == 'accept_friend_request')) {
              _context.next = 25;
              break;
            }

            // $(el).html('<div class="lds-facebook"><div></div><div></div><div></div></div>');
            $(el).attr('class', 'button-outline-primary ml-auto');
            _context.next = 22;
            return $.get('/users/request/accept/' + $(el).data('user-id'));

          case 22:
            $(el).parents('#friend-request').fadeOut(500);
            _context.next = 30;
            break;

          case 25:
            if (!($(el).attr('id') == 'delete_friend_request')) {
              _context.next = 30;
              break;
            }

            // $(el).html('<div class="lds-facebook"><div></div><div></div><div></div></div>');
            $(el).attr('class', 'button-outline-primary ml-auto');
            _context.next = 29;
            return $.get('/users/request/delete/' + $(el).data('user-id'));

          case 29:
            $(el).parents('#friend-request').fadeOut(500);

          case 30:
          case "end":
            return _context.stop();
        }
      }
    }, _callee);
  }));
  return _handleFriendRequest.apply(this, arguments);
}

function handlePostLikes() {
  return _handlePostLikes.apply(this, arguments);
} // handle adding comment request


function _handlePostLikes() {
  _handlePostLikes = _asyncToGenerator(
  /*#__PURE__*/
  _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
    var likesCount, likesBox;
    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
      while (1) {
        switch (_context2.prev = _context2.next) {
          case 0:
            _context2.next = 2;
            return $.get('/posts/' + $(this).data('post-id') + '/liked');

          case 2:
            likesCount = _context2.sent;
            $(this).toggleClass('text-primary text-gray-500 hover:text-gray-600'); // display & update likes count on post

            likesBox = $(this).parents('.post-box').find('.post-likes-count');

            if (likesBox.hasClass('hidden') || likesCount == 0) {
              likesBox.toggleClass('hidden');
            }

            likesBox.children('.likes-count').html(likesCount);

          case 7:
          case "end":
            return _context2.stop();
        }
      }
    }, _callee2, this);
  }));
  return _handlePostLikes.apply(this, arguments);
}

function addComment(_x2, _x3, _x4) {
  return _addComment.apply(this, arguments);
} // Update comment


function _addComment() {
  _addComment = _asyncToGenerator(
  /*#__PURE__*/
  _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee3(form, data, url) {
    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee3$(_context3) {
      while (1) {
        switch (_context3.prev = _context3.next) {
          case 0:
            _context3.next = 2;
            return $.ajax({
              url: url,
              type: 'post',
              data: data,
              success: function success(_success) {
                var userName = form.data('user-name');
                var userPath = form.data('user-path');
                var postId = form.data('post-id');
                var commentId = _success.commentId;
                var commentPath = _success.commentPath;
                var userImgSrc = form.data('user-img-src');
                var newComment = "\n\t\t\t\t<div class=\"user-comment\">\n\t\t\t\t\t<div class=\"pl-4 mt-4\">\n\t             \t<div class=\"flex\">\n\t\t\t\t\t\t\t<div class=\"w-1/12\">\n\t\t\t\t\t\t\t   <a href=\"".concat(userPath, "\"><img src=\"").concat(userImgSrc, "\" class=\"rounded-full w-10 border\"></a>\n\t\t\t\t\t\t\t</div>\n\n\t\t\t\t\t\t\t<div class=\"w-11/12 bg-main py-2 px-4 border border-gray-200 rounded text-gray-600 ml-2 relative\"\n\t\t\t\t\t\t\t\t  style=\"word-wrap: break-word;border-radius: 1.25rem;\">\n                         <i class=\"show-options fa fa-ellipsis-h absolute right-0 mr-2 text-gray-500 hover:text-gray-600 cursor-pointer mr-4 text-xl\"></i>\n\n                         <div class=\"options absolute card mr-10 right-0 text-center w-40 cursor-auto z-10\" style=\"top:-8px;display:none\">\n                             <ul>\n                                 <a data-comment-id=\"").concat(commentId, "\"\n                                    data-post-id=\"").concat(postId, "\"\n                                    href=\"#comment-modal\"\n                                    rel=\"modal:open\" \n                                    class=\"open-comment-modal\"\n                                 >\n                                     <li class=\"cursor-pointer hover:text-gray-900 text-gray-600 py-1\" id=\"open-comment-modal\">Edit Comment</li>\n                                 </a>\n\n                                 <button class=\"delete-comment cursor-pointer hover:text-gray-900 text-gray-600 py-1\"\n                                         data-comment-url=\"").concat(commentPath, "\"\n                                  >Delete Comment</button>\n                             </ul>\n                         </div>\n\n\t\t\t\t\t\t\t\t<p>\n\t                        <a href=\"").concat(userPath, "\" class=\"text-gray-700 text-lg\">\n\t                           ").concat(userName, "\n\t                        </a>\n\n\t                        <span class=\"text-gray-500 text-xs ml-2\">\n\t                           just now\n\t                        </span>\n\t                     </p>\n\n\t\t\t\t\t\t\t\t<p class=\"comment-body\">").concat(data.body, "</p>\n\t\t\t\t\t\t\t</div>\n\t             \t</div>\n\t          \t</div>\n          \t</div>\n\t\t\t");
                form.parents('.comments-box').find('.user-comments').prepend(newComment);

                if (form.find('textarea').hasClass('border-red-300')) {
                  form.find('textarea').removeClass('border-red-300');
                }

                form.find('textarea').val('');
                form.find('.comment-error').toggle();
              },
              error: function error(_error2) {
                form.find('.comment-error').toggleClass('hidden').html(_error2.responseJSON.errors.body[0]);
                form.find('textarea').toggleClass('border-gray-300 border-red-300');
              }
            });

          case 2:
          case "end":
            return _context3.stop();
        }
      }
    }, _callee3);
  }));
  return _addComment.apply(this, arguments);
}

function updateComment(_x5, _x6, _x7) {
  return _updateComment.apply(this, arguments);
}

function _updateComment() {
  _updateComment = _asyncToGenerator(
  /*#__PURE__*/
  _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee4(form, data, url) {
    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee4$(_context4) {
      while (1) {
        switch (_context4.prev = _context4.next) {
          case 0:
            _context4.next = 2;
            return $.ajax({
              url: url,
              type: 'post',
              data: data,
              success: function success(_success2) {
                form.find('textarea').toggleClass('border-gray-300 border-red-300');
                form.find('textarea').val('');
                form.find('.comment-error').toggle();
                form.siblings('.close-modal').click();
                window.commentToEdit.text(data.body);
              },
              error: function error(_error3) {
                form.find('.comment-error').toggle().html(_error3.responseJSON.errors.body[0]);
                form.find('textarea').toggleClass('border-gray-300 border-red-300');
              }
            });

          case 2:
          case "end":
            return _context4.stop();
        }
      }
    }, _callee4);
  }));
  return _updateComment.apply(this, arguments);
}

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /var/www/network/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /var/www/network/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });