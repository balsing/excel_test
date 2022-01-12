package main

import (
    "runtime"
    "fmt"
    "os"
    "github.com/xuri/excelize/v2"
    "encoding/csv"
    "log"
    "time"
    "flag"
)

var memoryDebug *bool
var timeDebug *bool
var filepath *string

func timeTrack(start time.Time, name string) {
    if *timeDebug == true {
        elapsed := time.Since(start)
        log.Printf("%s took %s", name, elapsed)
    }
}

func main() {
    memoryDebug = flag.Bool("memory", false, "display memory usage")
    timeDebug = flag.Bool("time", false, "display time info")
    filepath = flag.String("file", "", "path to file")
    flag.Parse()

    if len(*filepath) == 0 {
        log.Println("Filepath not setted")
    } else {
        data := readFile(*filepath)
        saveData(data)

        log.Println("DONE")
    }
}


func saveData(data [][]string) {
    defer timeTrack(time.Now(), "saveData")
    defer PrintMemUsage()

    file, err := os.Create("result.csv")
    checkError("Cannot create file", err)
    defer file.Close()

    writer := csv.NewWriter(file)
    writer.Comma = ';'
    defer writer.Flush()

    for _, value := range data {
        err := writer.Write(value)
        checkError("Cannot write to file", err)
    }
}

func readFile(filepath string) (rows [][]string) {
    defer timeTrack(time.Now(), "getRows")

    f, err := excelize.OpenFile(filepath)
    if err != nil {
        fmt.Println(err)
        return
    }
    defer func() {
        if err := f.Close(); err != nil {
            fmt.Println(err)
        }
    }()

    firstSheet := f.WorkBook.Sheets.Sheet[0].Name

    rows, err = f.GetRows(firstSheet)
    checkError("Cannot get rows", err)

    return rows
}

func checkError(message string, err error) {
    if err != nil {
        log.Fatal(message, err)
    }
}

func PrintMemUsage() {
    if *memoryDebug == true {
        var m runtime.MemStats
        runtime.ReadMemStats(&m)
        // For info on each, see: https://golang.org/pkg/runtime/#MemStats
        fmt.Printf("Alloc = %v MiB", bToMb(m.Alloc))
        fmt.Printf("\tSys = %v MiB", bToMb(m.Sys)) // Sys: общий объем памяти (адресное пространство), запрошенный у ОС.
        fmt.Printf("\tHeapSys = %v MiB", bToMb(m.HeapSys))
    }
}

func bToMb(b uint64) uint64 {
    return b / 1024 / 1024
}